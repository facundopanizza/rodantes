<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
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

        $users = User::all();

        return View("users.index", compact("users"));
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

        return view("users.create");
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
            "name" => [ "required", "string" ],
            "role" => [ "required", Rule::in([ "admin", "employee", "moderator" ])],
            "dni" => [ "nullable", "sometimes", Rule::requiredIf($request->role === "employee"), "unique:users" ],
            "email" => [ "nullable", "sometimes", Rule::requiredIf($request->role === "admin" || $request->role === "moderator"), "unique:users" ],
            "password" => [ Rule::requiredIf($request->role === "admin" || $request->role === "moderator") ],
        ]);

        $validated["password"] = Hash::make($validated["password"]);

        User::create($validated);

        return redirect()->route("users.index")->with("message", "El usuario fue creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        return View("users.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $validated = $request->validate([
            "name" => [ "required", "string" ],
            "role" => [ "required", Rule::in([ "admin", "employee", "moderator" ])],
            "dni" => [ "nullable", Rule::requiredIf($request->role === "employee"), Rule::unique('users')->ignore($user->dni, 'dni') ],
            "email" => [ "nullable", Rule::requiredIf($request->role === "admin" || $request->role === "moderator"), Rule::unique('users')->ignore($user->email, 'email') ],
            "password" => [ Rule::requiredIf($request->role === "admin" || $request->role === "moderator") ],
        ]);

        $validated["password"] = Hash::make($validated["password"]);

        if ($validated["role"] === "employee") {
            $user->email = null;
            $user->password = null;
            $user->dni = $validated["dni"];
        } else {
            $user->dni = null;
            $user->password = $validated["password"];
            $user->email = $validated["email"];
        }

        $user->name = $validated["name"];

        $user->save();

        return redirect()->route("users.index")->with("message", "El usuario fue editado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role !== "admin" && Auth::user()->role !== "moderator") {
            return View("403");
        }

        $user->delete();

        return redirect()->route("users.index")->with("message", "El usuario fue borrado correctamente");
    }

    public function empleadosLogin()
    {
        return View("auth.loginEmpleados");
    }

    public function empleadosLoginBack(Request $request)
    {
        $validated = $request->validate([
            "dni" => [ "required", "string", "exists:users,dni"]
        ]);

        $user = User::where("dni", $validated["dni"])->first();

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
