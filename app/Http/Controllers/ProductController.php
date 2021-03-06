<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function home()
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {

            return View("403");
        }

        $products = Product::all();

        $products = $products->filter(function ($product) {
            $notifyWhenStockIsEqualOrLessTo = 5;

            if ($product->getStock() <= $notifyWhenStockIsEqualOrLessTo) {
                return true;
            } else {
                return false;
            }
        });

        return view("index", compact("products"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "employee" && Auth::user()->role !== "moderator") {
            return View("403");
        }

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
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

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
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $validated = $request->validate([
            "name" => ["required", "string"],
            "picture" => ["image"]
        ]);

        if ($request->supplier_id && Supplier::find($request->supplier_id)) {
            $validated["supplier_id"] = $request->supplier_id;
        }

        if (array_key_exists("picture", $validated)) {
            $validated["picture"] = "storage/" . $request->file("picture")->store("products");
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
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "employee" && Auth::user()->role !== "moderator") {
            return View("403");
        }

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
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

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
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $validated = $request->validate([
            "name" => ["required", "string"],
            "picture" => ["image"],
        ]);

        if ($request->supplier_id && Supplier::find($request->supplier_id)) {
            $validated["supplier_id"] = $request->supplier_id;
        }

        if (array_key_exists("picture", $validated)) {
            Storage::delete($product->picture);
            $product->picture = "storage/" . $request->file("picture")->store("products");
        }
        
        $product->name = $validated["name"];
        $product->description = $request->description;

        if (array_key_exists("supplier_id", $validated)) {
            $product->supplier_id = $validated["supplier_id"];
        }

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
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        try {
            $product->delete();
            Storage::delete($product->picture);

            return redirect()->route("products.index");
        } catch (\Throwable $th) {
            if ($th->getCode() === "23000") {
                return redirect()->back()->withErrors([ "constrained" => "El producto no puede ser borrado porque tiene asignado uno o varios precios." ]);
            }
            throw $th;
        }
    }

    public function addToCaravan(Product $product)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "employee") {
            return View("403");
        }

        $caravans = Caravan::with("client")->get();

        return view("products.addToCaravan", [
            "caravans" => $caravans,
            "product" => $product
        ]);
    }
}
