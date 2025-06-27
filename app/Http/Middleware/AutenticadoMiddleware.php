<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AutenticadoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('usuario_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
