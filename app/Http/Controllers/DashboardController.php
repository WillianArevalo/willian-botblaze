<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $userCount = User::count();
        $productCount = Product::count();
        $movementCount = Movement::count();
        $movements = Movement::orderBy("created_at", "desc")->take(5)->get();
        return view("dashboard.index", compact("userCount", "productCount", "movementCount", "movements"));
    }
}
