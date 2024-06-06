<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function validate(LoginRequest $request)
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


    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect("/")->with("success", "Sesión cerrada correctamente");
    }
}
