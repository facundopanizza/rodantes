<?php

use App\Http\Controllers\CaravanController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name("home");

Route::resource("suppliers", SupplierController::class);
Route::resource("products", ProductController::class);
Route::resource("clients", ClientController::class);
Route::resource("caravans", CaravanController::class);

Route::get("/api/suppliers", function () {
    return Supplier::all();
});

Route::get("/prices/create/{product_id}", [PriceController::class, "create"])->name("prices.create");
Route::post("/prices/create/{product_id}", [PriceController::class, "store"])->name("prices.store");
Route::get("/prices/{price}/edit", [PriceController::class, "edit"])->name("prices.edit");
Route::delete("/prices/{price}", [PriceController::class, "destroy"])->name("prices.destroy");
Route::patch("/prices/{price}", [PriceController::class, "update"])->name("prices.update");

Route::get("/caravans/{caravan}/add_product/{price}", [CaravanController::class, "addProductForm"])->name("caravans.add_product_form");
Route::patch("/caravans/{caravan}/add_product_edit", [CaravanController::class, "addProductEdit"])->name("caravans.add_product_edit");
Route::get("/caravans/{caravan}/sub_product/{price}", [CaravanController::class, "subProductForm"])->name("caravans.sub_product_form");
Route::patch("/caravans/{caravan}/sub_product", [CaravanController::class, "subProduct"])->name("caravans.sub_product");
Route::post("/caravans/{caravan}/add_product", [CaravanController::class, "addProduct"])->name("caravans.add_product");
Route::get("/caravans/{caravan}/results", [CaravanController::class, "results"])->name("caravans.results");
