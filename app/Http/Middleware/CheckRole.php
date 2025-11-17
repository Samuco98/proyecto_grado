<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja el acceso según el rol.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();

        // Si no hay usuario autenticado, redirigir a login
        if (!$user) {
            return redirect()->route('login');
        }

        //  ADMINISTRADOR siempre puede acceder a todo
        if ($user->rol === 'admin') {
            return $next($request);
        }

        // 👷 Si es empleado, solo puede entrar al rol que corresponde
        if ($user->rol === $role) {
            return $next($request);
        }

        //  Acceso no autorizado
        abort(403, 'Acceso no autorizado');
    }
}
