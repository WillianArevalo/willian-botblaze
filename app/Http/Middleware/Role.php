<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect("/");
        }

        $user = Auth::user();

        if ($user->role != $role) {
            switch ($user->role) {
                case 'admin':
                    return redirect("/dashboard");
                    break;
                case 'user':
                    return redirect("/home");
                    break;
            }
        }

        return $next($request);
    }
}
