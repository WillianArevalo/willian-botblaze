<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovementRequest;
use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index()
    {
        $movements = Movement::paginate(10);
        return view("movements.index", ["movements" => $movements]);
    }

    public function input()
    {
        $products = Product::all();
        return view("movements.create", ["type" => "input", "products" => $products]);
    }

    public function output()
    {
        $products = Product::all()->where("stockCurrent", ">", 0);
        return view("movements.create", ["type" => "output", "products" => $products]);
    }

    public function store(MovementRequest $request)
    {
        $validateData = $request->validated();
        $product = Product::find($validateData["product_id"]);

        if ($product) {

            $movement = Movement::where("product_id", $product->id);
            if ($movement->count() == 0) {
                //Movimiento inicial
                if ($validateData["quantity"] == $product->stockInitial) {
                    Movement::create($validateData);
                    return redirect()->route("movements.index")->with("success", "Movement created");
                } else {
                    return redirect()->route("movements.index")->with("error", "Initial stock must be equal to the quantity");
                }
            }

            if ($validateData["typeMovement"] == "input") {
                $stock = $product->stockCurrent + $validateData["quantity"];
                $product->stockCurrent = $stock;
            } else {

                if ($product->stockCurrent < $validateData["quantity"]) {
                    return redirect()->route("movements.index")->with("error", "Insufficient stock");
                }

                $stock = $product->stockCurrent -  $validateData["quantity"];
                $product->status = $this->updateStatus($stock);
                $product->stockCurrent = $stock;
            }
        } else {
            return redirect()->route("movements.index")->with("error", "Product not found");
        }
        $product->save();
        Movement::create($validateData);
        return redirect()->route("movements.index")->with("success", "Movement created");
    }

    public function edit($id)
    {

        $movement = Movement::find($id);
        $product = Product::find($movement->product_id);

        $isMovementInital = false;
        $movementInitial = Movement::where("product_id", $product->id)->orderBy("created_at", "asc")->first();

        if ($movementInitial->id == $movement->id) {
            $isMovementInital = true;
        }

        $products = Product::all();
        return view("movements.edit", ["movement" => $movement, "product" => $product, "products" => $products, "isMovementInitial" => $isMovementInital]);
    }

    public function update(MovementRequest $request, string $id)
    {
        $validateData = $request->validated();
        $movement = Movement::find($id);
        $quantity = $validateData["quantity"];
        $typeMovement = $validateData["typeMovement"];
        if ($movement) {
            $product = Product::find($validateData["product_id"]);
            if ($product) {
                if ($typeMovement == "input") {
                    switch ($movement->typeMovement) {
                        case "input":
                            $stockCurrent = $product->stockCurrent - $movement->quantity;
                            $newStock = $stockCurrent + $quantity;
                            break;
                        case "output":
                            $stockCurrent = $product->stockCurrent + $movement->quantity;
                            $newStock = $stockCurrent + $quantity;
                            break;
                    }
                    $product->status = $this->updateStatus($newStock);
                    $product->stockCurrent = $newStock;
                } else {

                    switch ($movement->typeMovement) {
                        case "input":
                            $stockCurrent = $product->stockCurrent - $movement->quantity;
                            if (!$this->validateStock($stockCurrent, $quantity)) {
                                return redirect()->route("movements.index")->with("error", "Insufficient stock");
                            }
                            $newStock = $stockCurrent - $quantity;
                            break;
                        case "output":
                            $stockCurrent = $product->stockCurrent + $movement->quantity;

                            if (!$this->validateStock($stockCurrent, $quantity)) {
                                return redirect()->route("movements.index")->with("error", "Insufficient stock");
                            }

                            $newStock = $stockCurrent - $quantity;
                            break;
                    }

                    $product->status = $this->updateStatus($newStock);
                    $product->stockCurrent = $newStock;
                }
            } else {
                return redirect()->route("movements.index")->with("error", "Product not found");
            }
            $product->save();
            $movement->update($validateData);
            return redirect()->route("movements.index")->with("success", "Movement updated");
        } else {
            return redirect()->route("movements.index")->with("error", "Movement not found");
        }
    }

    public function destroy($id)
    {
        $movement = Movement::find($id);
        if ($movement) {
            $product = Product::find($movement->product_id);
            if ($product) {

                $movementInitial = Movement::where("product_id", $product->id)->orderBy("created_at", "asc")->first();
                if ($movementInitial->id == $movement->id) {
                    return redirect()->route("movements.index")->with("error", "No se puede eliminar el movimiento inicial de un producto");
                }

                if ($movement->typeMovement == "input") {
                    $stock = $product->stockCurrent - $movement->quantity;
                } else {
                    $stock = $product->stockCurrent + $movement->quantity;
                }

                $product->status = $this->updateStatus($stock);
                $product->stockCurrent = $stock;
                $product->save();
            } else {
                return redirect()->route("movements.index")->with("error", "Product not found");
            }

            $movement->delete();
            return redirect()->route("movements.index")->with("success", "Movement deleted");
        } else {
            return redirect()->route("movements.index")->with("error", "Movement not found");
        }
    }

    public function updateStatus($stock)
    {
        if ($stock <= 5 && !($stock === 0)) {
            return "warning";
        } elseif ($stock === 0) {
            return "out_of_stock";
        } else {
            return "in_stock";
        }
    }

    public function validateStock($stockCurrent, $quantity)
    {
        if ($stockCurrent < $quantity) {
            return false;
        }
        return true;
    }
}
