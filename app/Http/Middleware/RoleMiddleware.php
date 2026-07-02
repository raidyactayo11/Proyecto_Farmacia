<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->role || !in_array(auth()->user()->role->nombre, $roles, true)) {
            $ruta = auth()->user()->role && auth()->user()->role->nombre === 'Cajero'
                ? 'dashboard.cajero'
                : 'dashboard.index';

            return redirect()
                ->route($ruta)
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
