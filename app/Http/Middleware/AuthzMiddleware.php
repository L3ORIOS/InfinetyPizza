<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthzMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar si el usuario está autenticado
        if (! auth()->check()) {
            return redirect('login'); // Redirigir al login si no está autenticado
        }

        // 2. Verificar el rol de administrador
        if (! auth()->user()->is_admin) {
            // Si no es administrador, redirigir a su dashboard normal
            // o abortar con un error 403 (No autorizado)
            return abort(403, 'Acceso denegado. No eres administrador.');
        }

        return $next($request);
    }
}
