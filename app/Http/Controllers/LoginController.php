<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view("login");
    }

    /**
     * Validate the user login
     * @param LoginRequest $request
     */
    public function validate(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->only("email", "password");
        $user = User::where("email", $credentials["email"])->first();

        if (!$user) {
            return back()->withErrors(["email" => "El email no existe"])->withInput(request()->only("email"))->with("error", "El email no existe");
        }

        if (!Hash::check($credentials["password"], $user->password)) {
            return back()->withErrors(["password" => "La contraseña es incorrecta"])->withInput(request()->only("email"))->with("error", "La contraseña es incorrecta");
        }

        Auth::login($user);
        $request->session()->regenerate();

        $request->session()->put(
            "user",
            [
                "name" => $user->name,
                "email" => $user->email,
                "photo" => $user->photo,
                "role"  => $user->role,
            ]
        );
        return redirect("/dashboard")->with("success", "Bienvenido, inicio de sesión correcto");
    }

    /**
     * Close the user session
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        session()->flush();
        return redirect("/")->with("success", "Sesión cerrada correctamente");
    }
}
