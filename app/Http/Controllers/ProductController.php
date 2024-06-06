<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
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
        $products = Product::all();
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
        Product::create($validateData);
        return redirect()->route("products.index")->with("success", "Product created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            return view("products.edit", ["product" => $product]);
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
}
