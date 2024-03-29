<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClientController extends Controller
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

        $clients = Client::all();

        return view("clients.index", compact("clients"));
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

        return view("clients.create");
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
            "first_name" => [ "required", "string" ],
            "last_name" => [ "required", "string" ],
            "email" => [ "string", "email", "nullable" ],
            "dni" => [ "string", "nullable" ],
            "address" => [ "string", "nullable" ],
            "phone" => [ "string", "nullable" ],
            "picture" => [ "image", "nullable" ],
        ]);

        if (array_key_exists("picture", $validated)) {
            $validated["picture"] = "storage/" . $request->file("picture")->store("clients");
        }

        Client::create($validated);

        return redirect()->route("clients.index")->with("message", "El cliente fue creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        return view("clients.edit", compact("client"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $validated = $request->validate([
            "first_name" => [ "required", "string" ],
            "last_name" => [ "required", "string" ],
            "email" => [ "string", "nullable", "email", Rule::unique('clients')->ignore($client->email, 'email') ],
            "dni" => [ "string", "nullable", Rule::unique('clients')->ignore($client->dni, 'dni') ],
            "phone" => [ "string", "nullable" ],
            "address" => [ "string", "nullable" ],
            "picture" => [ "image", "nullable" ],
        ]);

        if (array_key_exists("picture", $validated)) {
            Storage::delete(str_replace("storage/", "", $client->picture));
            $client->picture = "storage/" . $request->file("picture")->store("clients");
        }

        $client->first_name = $validated["first_name"];
        $client->last_name = $validated["last_name"];
        $client->email = $validated["email"];
        $client->dni = $validated["dni"];
        $client->phone = $validated["phone"];
        $client->address = $validated["address"];
        $client->save();

        return redirect()->route("clients.index")->with("message", "El cliente fue editado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        try {
            Storage::delete($client->picture);
            $client->delete();

            return redirect()->route("clients.index")->with("message", "El cliente fue borrado correctamente");
        } catch (\Throwable $th) {
            if ($th->getCode() === "23000") {
                return redirect()->back()->withErrors([ "constrained" => "El cliente no puede ser borrado porque tiene asignado una o varias caravanas." ]);
            }
            throw $th;
        }
    }
}
