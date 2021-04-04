<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
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
        $validated = $request->validate([
            "first_name" => [ "required", "string" ],
            "last_name" => [ "required", "string" ],
            "email" => [ "required", "string", "email", "unique:clients,email" ],
            "dni" => [ "required", "string", "unique:clients,dni" ],
            "address" => [ "required", "string" ],
            "phone" => [ "required", "string" ],
            "picture" => [ "image" ],
        ]);

        if (array_key_exists("picture", $validated)) {
            $validated["picture"] = "storage/" . $request->file("picture")->store("clients");
        }

        Client::create($validated);

        return redirect()->route("clients.index");
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
        $validated = $request->validate([
            "first_name" => [ "required", "string" ],
            "last_name" => [ "required", "string" ],
            "email" => [ "required", "string", "email", Rule::unique('clients')->ignore($client->email, 'email') ],
            "dni" => [ "required", "string", Rule::unique('clients')->ignore($client->dni, 'dni') ],
            "phone" => [ "required", "string" ],
            "address" => [ "required", "string" ],
            "picture" => [ "image" ],
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

        return redirect()->route("clients.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try {
            Storage::delete($client->picture);
            $client->delete();

            return redirect()->route("clients.index");
        } catch (\Throwable $th) {
            if ($th->getCode() === "23000") {
                return redirect()->back()->withErrors([ "constrained" => "El cliente no puede ser borrado porque tiene asignado una o varias caravanas." ]);
            }
            throw $th;
        }
    }
}
