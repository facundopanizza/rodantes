<?php

namespace App\Http\Controllers; 
use App\Models\Caravan;
use App\Models\Client;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CaravanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caravans = Caravan::with("client")->get();

        return view("caravans.index", compact("caravans"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("caravans.create");
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
            "name" => [ "required", "string" ],
            "plate" => [ "required", "string", "unique:caravans,plate" ]
        ]);

        Caravan::create($validated);

        return redirect()->route("caravans.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caravan  $caravan
     * @return \Illuminate\Http\Response
     */
    public function show(Caravan $caravan)
    {
        return view("caravans.show", compact("caravan"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Caravan  $caravan
     * @return \Illuminate\Http\Response
     */
    public function edit(Caravan $caravan)
    {
        $clients = Client::all();

        return view("caravans.edit", [
            "caravan" => $caravan,
            "clients" => $clients
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caravan  $caravan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caravan $caravan)
    {
        $validated = $request->validate([
            "name" => [ "required", "string" ],
            "plate" => [ "required", "string" ],
            "client_id" => [ "required", "exists:clients,id"]
        ]);

        $caravan->name = $validated["name"];
        $caravan->plate = $validated["plate"];
        $caravan->client_id = $validated["client_id"];
        $caravan->save();

        return redirect()->route("caravans.show", $caravan->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caravan  $caravan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caravan $caravan)
    {
        $caravan->delete();

        return redirect()->route("caravans.index");
    }

    public function addProductForm(Caravan $caravan, Price $price)
    {
        return view("caravans.add_product", [ 
            "caravan" => $caravan, 
            "price" => $price 
        ]);
    }

    public function addProductEdit(Caravan $caravan, Request $request)
    {
        $validated = $request->validate([
            "price_id" => [ "required", "exists:prices,id" ],
            "quantity" => [ "required", "min:1" ]
        ]);

        $price = Price::find($validated["price_id"]);
        $pivot = $caravan->products->where("id", $price->id)->first()->pivot;
        $pricesAssigned = $pivot->quantity;

        if ($price->stock < $validated["quantity"]) {
            return back()->withErrors([ "quantity" => "Este precio no tiene stock suficiente." ])->withInput();
        }

        $pivot->quantity += $validated["quantity"];
        $pivot->save();
        $price->stock -= $validated["quantity"];
        $price->save();

        return redirect()->route("caravans.show", $caravan->id);
    }


    public function addProduct(Caravan $caravan, Request $request)
    {
        $validated = $request->validate([
            "term" => [ "required" ],
            "quantity" => [ "required", "min:1" ]
        ]);

        $product = Product::find($validated["term"]);

        if(!$product) {
            return redirect()->route("caravans.results", [
                "caravan" => $caravan,
                "term" => $validated["term"],
                "quantity" => $validated["quantity"],
            ]);
        }

        if (!$product->assignCaravan($caravan, $validated["quantity"])) {
            return back()->withErrors([ "quantity" => "Este producto no tiene suficiente stock." ])->withInput();
        }

        return redirect()->route("caravans.show", $caravan->id);
    }

    public function subProductForm(Caravan $caravan, Price $price)
    {
        return view("caravans.sub_product", [ 
            "caravan" => $caravan, 
            "price" => $price 
        ]);
    }

    public function subProduct(Caravan $caravan, Request $request)
    {
        $validated = $request->validate([
            "price_id" => [ "required", "exists:prices,id" ],
            "quantity" => [ "required", "min:1" ]
        ]);

        $price = Price::find($validated["price_id"]);
        $pivot = $caravan->products->where("id", $price->id)->first()->pivot;
        $pricesAssigned = $pivot->quantity;

        if (($pricesAssigned - $request["quantity"]) < 0) {
            return back()->withErrors([ "quantity" => "La cantidad a quitar no puedo superar la cantidad asignada." ])->withInput();
        }

        $pivot->quantity -= $validated["quantity"];
        $pivot->save();
        $price->stock += $validated["quantity"];
        $price->save();

        if ($pivot->quantity === 0) {
            $caravan->products()->detach($price->id);
        }

        return redirect()->route("caravans.show", $caravan->id);
    }

    public function results(Caravan $caravan, Request $request)
    {
        $validated = $request->validate([
            "term" => [ "required" ],
            "quantity" => [ "required", "min:1" ]
        ]);

        $products = Product::orWhere("name", "LIKE", "%" . $validated["term"] . "%")
                                    ->whereOr("id", "LIKE", "%" . $validated["term"] . "%")
                                    ->get();

        if ($products->isEmpty()) {
            return back()->withErrors([ "term" => "No se encontro un producto con este termino de busqueda." ])->withInput();
        }

        return view("caravans.results", [
            "caravan" => $caravan,
            "term" => $validated["term"],
            "quantity" => $validated["quantity"],
            "products" => $products
        ]);
    }
}
