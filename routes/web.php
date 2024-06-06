<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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
