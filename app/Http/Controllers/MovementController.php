<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovementRequest;
use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;

class MovementController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $movements = Movement::with("product")->paginate(10);
        return view("movements.index", ["movements" => $movements]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     */
    public function input(): \Illuminate\Contracts\View\View
    {
        $products = Product::all();
        return view("movements.create", ["type" => "input", "products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     */
    public function output(): \Illuminate\Contracts\View\View
    {
        $products = Product::all()->where("stockCurrent", ">", 0);
        return view("movements.create", ["type" => "output", "products" => $products]);
    }

    /**
     * Store a newly created resource in storage.
     * @param MovementRequest $request
     */
    public function store(MovementRequest $request): \Illuminate\Http\RedirectResponse
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
                    return redirect()->route("movements.index")->with("error", "No hay suficiente stock para realizar la salida");
                }
                $stock = $product->stockCurrent -  $validateData["quantity"];
                $product->stockCurrent = $stock;
            }
        } else {
            return redirect()->route("movements.index")->with("error", "Producto no encontrado");
        }
        $product->status = $this->updateStatus($stock);
        $product->save();
        Movement::create($validateData);
        return redirect()->route("movements.index")->with("success", "Movimiento creado correctamente");
    }

    /**
     * Display the specified resource.
     * @param string $id
     */
    public function edit($id): \Illuminate\Contracts\View\View
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

    /**
     * Update the specified resource in storage.
     * @param MovementRequest $request
     * @param string $id
     */
    public function update(MovementRequest $request, string $id): \Illuminate\Http\RedirectResponse
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
                                return redirect()->route("movements.index")->with("error", "No se puedo editar, no hay suficiente stock para registar la salida");
                            }
                            $newStock = $stockCurrent - $quantity;
                            break;
                        case "output":
                            $stockCurrent = $product->stockCurrent + $movement->quantity;

                            if (!$this->validateStock($stockCurrent, $quantity)) {
                                return redirect()->route("movements.index")->with("error", "No se puedo editar, no hay suficiente stock para registar la salida");
                            }

                            $newStock = $stockCurrent - $quantity;
                            break;
                    }

                    $product->status = $this->updateStatus($newStock);
                    $product->stockCurrent = $newStock;
                }
            } else {
                return redirect()->route("movements.index")->with("error", "Producto no encontrado");
            }
            $product->save();
            $movement->update($validateData);
            return redirect()->route("movements.index")->with("success", "Movimiento actualizado correctamente");
        } else {
            return redirect()->route("movements.index")->with("error", "Movimiento no encontrado");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
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
                return redirect()->route("movements.index")->with("error", "Producto no encontrado");
            }

            $movement->delete();
            return redirect()->route("movements.index")->with("success", "Movimiento eliminado correctamente");
        } else {
            return redirect()->route("movements.index")->with("error", "Movimiento no encontrado");
        }
    }

    /**
     * Update the status of the product
     * @param int $stock
     */
    public function updateStatus(int $stock): string
    {
        if ($stock <= 5 && !($stock === 0)) {
            return "warning";
        } elseif ($stock === 0) {
            return "out_of_stock";
        } else {
            return "in_stock";
        }
    }

    /**
     * Validate the stock
     * @param int $stockCurrent
     * @param int $quantity
     */
    public function validateStock(int $stockCurrent, int $quantity): bool
    {
        if ($stockCurrent < $quantity) {
            return false;
        }
        return true;
    }
}
