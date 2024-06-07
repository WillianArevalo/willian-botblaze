<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Movement;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view("products.index", ["products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validateData = $request->validated();
        $validateData["stockCurrent"] = $validateData["stockInitial"];
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . "/images/products", $name);
            $validateData["image"] = $name;
        }

        $product = Product::create($validateData);
        $movement = new Movement();
        $movement->product_id = $product->id;
        $movement->typeMovement = "input";
        $movement->quantity = $product->stockInitial;
        $movement->description = "Entrada inicial del producto";
        $movement->date = now();
        $movement->save();
        return redirect()->route("products.index")->with("success", "Product created and movement initial created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            return view("products.show", ["product" => $product]);
        } else {
            return redirect()->route("products.index")->with("error", "Product not found");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $searchMovement = false;
            $movement = Movement::where("product_id", $product->id);
            if ($movement->count() > 0) {
                $searchMovement = true;
            }
            return view("products.edit", ["product" => $product, "searchMovement" => $searchMovement]);
        } else {
            return redirect()->route("products.index")->with("error", "Product not found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $validateData = $request->validated();
        $product = Product::find($id);

        $movement = Movement::where("product_id", $product->id);
        if ($movement->count() > 0) {
            if ($product->stockInitial != $validateData["stockInitial"]) {
                return redirect()->route("products.index")->with("error", "Product has movements");
            }
        }

        if ($product) {
            if ($request->hasFile("image")) {

                if ($product->image) {
                    $imagePath = public_path("images/products/" . $product->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }

                $file = $request->file("image");
                $name = time() . $file->getClientOriginalName();
                $file->move(public_path() . "/images/products", $name);
                $validateData["image"] = $name;
            }
            $newStockCurrent = $product->stockCurrent - $product->stockInitial + $validateData["stockInitial"];
            $validateData["stockCurrent"] = $newStockCurrent;
            $product->update($validateData);
            return redirect()->route("products.index")->with("success", "Product updated");
        } else {
            return redirect()->route("products.index")->with("error", "Product not found");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->image) {
                $imagePath = public_path("images/products/" . $product->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            $product->delete();
            return redirect()->route("products.index")->with("success", "Product deleted");
        } else {
            return redirect()->route("products.index")->with("error", "Product not found");
        }
    }

    public function search(Request $request)
    {
        $query = Product::query();
        if ($request->input("searchProduct")) {
            $name = $request->input("searchProduct");
            $query->where("name", "like", "%$name%");
        }

        if ($request->input("searchStatus")) {
            $status = $request->input("searchStatus");
            $query->where("status", $status);
        }
        $products = $query->get();

        $window = $request->input("window");

        if ($window == "desktop") {
            return view("layouts.__partials.product-row", ["products" => $products]);
        } else {
            return view("layouts.__partials.card-product", ["products" => $products]);
        }
    }
}
