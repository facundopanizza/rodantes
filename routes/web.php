<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource("suppliers", SupplierController::class);
Route::resource("products", ProductController::class);
Route::resource("clients", ClientController::class);

Route::get("/prices/create/{product_id}", [PriceController::class, "create"])->name("prices.create");
Route::post("/prices/create/{product_id}", [PriceController::class, "store"])->name("prices.store");
Route::get("/prices/{price}/edit", [PriceController::class, "edit"])->name("prices.edit");
Route::delete("/prices/{price}", [PriceController::class, "destroy"])->name("prices.destroy");
Route::patch("/prices/{price}", [PriceController::class, "update"])->name("prices.update");
