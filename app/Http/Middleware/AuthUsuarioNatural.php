<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthUsuarioNatural
{
    
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('usuario_natural')->check()) {
            return redirect('/login')->withErrors('Acceso denegado.');
        }
        return $next($request);
    }
}
