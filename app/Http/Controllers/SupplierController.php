<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $suppliers = Supplier::latest()->get();

        return view("suppliers.index", compact("suppliers"));
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

        return view("suppliers.create");
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
            "name" => ["required", "unique:suppliers"],
            "phone" => [ "string", "nullable" ],
            "address" => [ "string", "nullable" ]
        ]);

        Supplier::create($validated);

        return redirect()->route("suppliers.index")->with("message", "El proveedor fue creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        return view("suppliers.edit", compact("supplier"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $validated = $request->validate([
            "name" => [ "required", "string", Rule::unique('suppliers')->ignore($supplier->name, 'name') ],
            "phone" => [ "string", "nullable" ],
            "address" => [ "string", "nullable" ]
        ]);

        $supplier->name = $validated["name"];
        $supplier->phone = $validated["phone"];
        $supplier->address = $validated["address"];
        $supplier->save();

        return redirect()->route("suppliers.index")->with("message", "El proveedor fue editado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $supplier->delete();

        return redirect()->route("suppliers.index")->with("message", "El proveedor fue borrado correctamente");
    }
}
