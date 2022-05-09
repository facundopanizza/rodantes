<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaravanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Supplier;

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

Route::middleware(["auth"])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name("home");

    Route::get("/products/stock", [ProductController::class, 'home'])->name("stock");

    Route::get("/products/{product}/addToCaravan", [ProductController::class, 'addToCaravan'])->name("products.addToCaravan");
    Route::post("/products/{product}/addToCaravan", [CaravanController::class, "addProduct"])->name("products.storeToCaravan");

    Route::resource("suppliers", SupplierController::class);

    Route::get("/products/pdf", [ ProductController::class, "pdf" ])->name("products.pdf");
    Route::resource("products", ProductController::class);

    Route::resource("clients", ClientController::class);
    Route::resource("caravans", CaravanController::class);
    Route::resource("categories", CategoryController::class);
    Route::resource("employees", EmployeeController::class);

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

    Route::get("/users/create", [UserController::class, "create"])->name("users.create");
    Route::post("/users", [UserController::class, "store"])->name("users.store");
});

Route::get("/admins", function () {
    return View("auth.loginAdmin");
})->name("admins.login");
Route::get("/users", [UserController::class, "index"])->name("users.index");
Route::get("/users/{user}/edit", [UserController::class, "edit"])->name("users.edit");
Route::patch("/users/{user}", [UserController::class, "update"])->name("users.update");
Route::delete("/users/{user}", [UserController::class, "destroy"])->name("users.destroy");
Route::get("/operadores", [UserController::class, "empleadosLogin"])->name("empleados.login");
Route::post("/operadores", [UserController::class, "empleadosLoginBack"])->name("empleados.loginBack");

Route::get("/403", function () {
    return View("403");
});

require __DIR__.'/auth.php';
