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
     * 
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $products = Product::paginate(10);
        return view("products.index", ["products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     * @param ProductRequest $request 
     */
    public function store(ProductRequest $request): \Illuminate\Http\RedirectResponse
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
        return redirect()->route("products.index")->with("success", "Producto y movimiento inicial creado correctamente");
    }

    /**
     * Display the specified resource.
     * @param string $id
     */
    public function show(string $id): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $product = Product::find($id);
        if ($product) {
            return view("products.show", ["product" => $product]);
        } else {
            return redirect()->route("products.index")->with("error", "Producto no encontrado");
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param string $id
     */
    public function edit(string $id): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
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
            return redirect()->route("products.index")->with("error", "Producto no encontrado");
        }
    }

    /**
     * Update the specified resource in storage.
     * @param ProductRequest $request
     * @param string $id
     */
    public function update(ProductRequest $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $validateData = $request->validated();
        $product = Product::find($id);

        $movement = Movement::where("product_id", $product->id);
        if ($movement->count() > 0) {
            if ($product->stockInitial != $validateData["stockInitial"]) {
                return redirect()->route("products.index")->with("error", "No se puede modificar el stock inicial, ya existen movimientos asociados al producto");
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
            return redirect()->route("products.index")->with("success", "Producto actualizado correctamente");
        } else {
            return redirect()->route("products.index")->with("error", "Producto no encontrado");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
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

    /**
     *  Search for a product
     *  @param Request $request 
     */

    public function search(Request $request): \Illuminate\Contracts\View\View
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
