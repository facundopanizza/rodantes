<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with("supplier")->get();

        return view("products.index", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();

        return view("products.create", compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string"],
            "description" => ["required", "string"],
            "picture" => ["image"],
            "supplier_id" => ["required", "exists:suppliers,id"]
        ]);

        if (array_key_exists("picture", $validated)) {
            $validated["picture"] = $request->file("picture")->store("products");
        }
        
        $product = Product::create($validated);

        return redirect()->route("products.show", $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load("prices");

        return view("products.show", [ "product" => $product ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $suppliers = Supplier::all();

        return view("products.edit", [ "suppliers" => $suppliers, "product" => $product ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            "name" => ["required", "string"],
            "description" => ["required", "string"],
            "picture" => ["image"],
            "supplier_id" => ["required", "exists:suppliers,id"]
        ]);

        if (array_key_exists("picture", $validated)) {
            Storage::delete($product->picture);
            $product->picture = $request->file("picture")->store("products");
        }
        
        $product->name = $validated["name"];
        $product->description = $validated["description"];
        $product->supplier_id = $validated["supplier_id"];
        $product->save();

        return redirect()->route("products.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::delete($product->picture);
        $product->delete();

        return redirect()->route("products.index");
    }
}
