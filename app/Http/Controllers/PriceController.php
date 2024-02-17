<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        return view("prices.create", compact("product_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $product_id)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $validated = $request->validate([
            "price" => [ "required", "min:0", "numeric"],
            "iva" => [ "min:0", "numeric"],
            "stock" => [ "min:0", "numeric"],
            "created_at" => [ "date", "nullable" ]
        ]);

        if (!$validated["created_at"]) {
            $validated["created_at"] = time();
        }

        $validated["product_id"] = $product_id;

        Price::create($validated);

        return redirect()->route("products.show", $product_id)->with("message", "El precio fue creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        return view("prices.edit", [ "price" => $price, "product_id" => $price->product->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $validated = $request->validate([
            "price" => [ "required", "min:0", "numeric"],
            "iva" => [ "min:0", "numeric"],
            "stock" => [ "min:0", "numeric"],
            "created_at" => [ "date", "nullable" ]
        ]);

        if (!$validated["created_at"]) {
            $validated["created_at"] = time();
        }

        $price->price = $validated["price"];
        $price->iva = $validated["iva"];
        $price->stock = $validated["stock"];
        $price->created_at = $validated["created_at"];
        $price->save();

        return redirect()->route("products.show", $price->product->id)->with("message", "El precio fue editado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        try {
            $product_id = $price->product->id;
            $price->delete();

            return redirect()->route("products.show", $product_id)->with("message", "El precio fue borrado correctamente");
        } catch (\Throwable $th) {
            if ($th->getCode() === "23000") {
                return redirect()->back()->withErrors([ "constrained" => "El precio no puede ser borrado porque esta asignado a una o varias caravanas." ]);
            }
            throw $th;
        }
    }
}
