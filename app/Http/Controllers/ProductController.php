<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf;

class ProductController extends Controller
{
    public function home()
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $products = Product::with("supplier")->with("prices")->get();

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
        return view("products.index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $products = Product::with("supplier")->with("prices")->get();

        $products->each(function ($product) {
            $product->stock = $product->getStock();
            $product->price = '$' . number_format($product->prices->max('price'), 2, ',', '.')  . '-$' . number_format($product->prices->min('price'), 2, ',', '.');
            $product->userRole = Auth::user()->role;

            return $product;
        });

        return $products;
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
        $categories = Category::all();

        return view("products.create", [
            "suppliers" => $suppliers,
            "categories" => $categories
        ]);
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

        if ($request->category_id && Category::find($request->category_id)) {
            $validated["category_id"] = $request->category_id;
        }

        if (array_key_exists("picture", $validated)) {
            $validated["picture"] = "storage/" . $request->file("picture")->store("products");
        }

        $validated["name"] = ucfirst($validated["name"]);

        $product = Product::create($validated);

        return redirect()->route("products.show", $product->id)->with("message", "El producto fue creado correctamente");
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
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $suppliers = Supplier::all();
        $categories = Category::all();

        return view("products.edit", [
            "suppliers" => $suppliers,
            "product" => $product,
            "categories" => $categories
        ]);
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

        if ($request->category_id && Category::find($request->category_id)) {
            $validated["category_id"] = $request->category_id;
        }

        if (array_key_exists("picture", $validated)) {
            Storage::delete($product->picture);
            $product->picture = "storage/" . $request->file("picture")->store("products");
        }

        $validated["name"] = ucfirst($validated["name"]);

        $product->name = $validated["name"];
        $product->description = $request->description;

        if (array_key_exists("supplier_id", $validated)) {
            $product->supplier_id = $validated["supplier_id"];
        }

        if (array_key_exists("category_id", $validated)) {
            $product->category_id = $validated["category_id"];
        }

        $product->save();

        return redirect()->route("products.index")->with("message", "El producto fue editado correctamente");
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

            return redirect()->route("products.index")->with("message", "El producto fue borrado correctamente");
        } catch (\Throwable $th) {
            if ($th->getCode() === "23000") {
                return redirect()->back()->withErrors([ "constrained" => "El producto no puede ser borrado porque tiene asignado uno o varios precios." ]);
            }
            throw $th;
        }
    }

    public function addToCaravan(Product $product)
    {
        $caravans = Caravan::with("client")->get();
        $employees = Employee::all();

        return view("products.addToCaravan", [
            "caravans" => $caravans,
            "product" => $product,
            "employees" => $employees
        ]);
    }

    public function pdf()
    {
        $categories = Category::with("products")->orderBy("name")->get()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);

        return SnappyPdf::loadView("products.pdf", [ "categories" => $categories ])->setOption("viewport-size", "1280x1024")->inline();
    }
}
