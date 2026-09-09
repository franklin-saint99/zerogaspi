<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!Auth::user()->actif) {
            Auth::logout();
            return redirect('/login')->with('error', 'Votre compte a été désactivé. Contactez l\'administrateur.');
        }

        if (Auth::user()->role !== $role) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}