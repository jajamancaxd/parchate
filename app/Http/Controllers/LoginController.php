<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UsuarioNatural;
use App\Models\UsuarioNegocio;
use App\Models\UsuarioAdministrador;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);
        
        
        $usuarioAdmin = UsuarioAdministrador::where('correo_electronico_administrador', $request->correo)->first();

        if ($usuarioAdmin && Hash::check($request->password, $usuarioAdmin->contraseña_administrador)) {
        Auth::guard('usuario_administrador')->loginUsingId($usuarioAdmin->id); 
        Session::put('tipo_cuenta', 'administrador');

        return redirect()->route('Administradores');
        }

        // 🔍 Intentar autenticación como Usuario Natural
        $usuarioNatural = UsuarioNatural::where('correo_electronico', $request->correo)->first();

        if ($usuarioNatural && Hash::check($request->password, $usuarioNatural->contraseña)) {
            Auth::guard('usuario_natural')->loginUsingId($usuarioNatural->id_usuario);
            Session::put('tipo_cuenta', 'natural');

            return redirect()->route('lugares.recomendados');
        }

        // 🔍 Intentar autenticación como Usuario Negocio
        $usuarioNegocio = UsuarioNegocio::where('correo_electronico_negocios', $request->correo)->first();

        if ($usuarioNegocio && Hash::check($request->password, $usuarioNegocio->contraseña_negocio)) {

            // ⛔ Validar si la cuenta está aceptada
            if ($usuarioNegocio->estado_de_cuenta_negocio !== 'aceptada') {
                return back()->withErrors([
                    'correo' => 'Tu cuenta aún no ha sido aceptada. Estado actual: ' . $usuarioNegocio->estado_de_cuenta_negocio
                ])->withInput();
            }

            Auth::guard('usuario_negocio')->loginUsingId($usuarioNegocio->id_negocio);
            Session::put('tipo_cuenta', 'negocio');

            return redirect()->route('sucursales.negocio');
        }

        // ❌ Si no coincide con ninguno
        return back()->withErrors(['correo' => 'Correo o contraseña incorrectos'])->withInput();
    }

    public function logout(Request $request)
    {
        // Detecta el guard activo y cierra sesión correctamente
        if (Session::get('tipo_cuenta') === 'natural') {
            Auth::guard('usuario_natural')->logout();
        } elseif (Session::get('tipo_cuenta') === 'negocio') {
            Auth::guard('usuario_negocio')->logout();
        }

        Session::flush(); // Limpia la sesión

        return redirect('/login');
    }
}
