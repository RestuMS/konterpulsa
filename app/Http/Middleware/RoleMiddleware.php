<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // CEK LOGIN DULU
        if (!auth()->check()) {
            return redirect('/login');
        }

        // CEK ROLE
        if (auth()->user()->role !== $role) {
            abort(403, 'Anda tidak punya akses');
        }

        return $next($request);
    }
}