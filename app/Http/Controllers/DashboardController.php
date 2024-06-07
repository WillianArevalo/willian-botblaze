<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $productCount = Product::count();
        $movementCount = Movement::count();
        $movements = Movement::orderBy("created_at", "desc")->take(5)->get();
        return view("dashboard.index", compact("userCount", "productCount", "movementCount", "movements"));
    }
}
