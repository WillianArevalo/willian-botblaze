<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::controller(LoginController::class)->group(function () {
    Route::get("/", "index")->name("login");
    Route::post("/validate", "validate")->name("login.validate");
    Route::post("/logout", "logout")->name("logout");
});

Route::middleware(["auth", "role:admin"])->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");
});

Route::resource("products", ProductController::class)->middleware(["auth", "role:admin"]);

Route::middleware(["auth", "role:admin"])->group(function () {
    Route::get("/movements", [MovementController::class, "index"])->name("movements.index");
    Route::get("/movements/output", [MovementController::class, "output"])->name("movements.output");
    Route::get("/movements/input", [MovementController::class, "input"])->name("movements.input");
    Route::post("/movements/store", [MovementController::class, "store"])->name("movements.store");
    Route::get("/movements/{id}", [MovementController::class, "show"])->name("movements.show");
    Route::get("/movements/{id}/edit", [MovementController::class, "edit"])->name("movements.edit");
    Route::put("/movements/{id}", [MovementController::class, "update"])->name("movements.update");
    Route::delete("/movements/{id}", [MovementController::class, "destroy"])->name("movements.destroy");
});
