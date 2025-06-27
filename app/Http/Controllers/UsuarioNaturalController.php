<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioNatural;
use App\Http\Controllers\Controller; // 👈 importante

class UsuarioNaturalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:usuario_natural'); // protege las rutas
    }

    // Mostrar perfil
    public function mostrarPerfil()
    {
        $usuario = Auth::guard('usuario_natural')->user(); // autenticado
        return view('usuario_natural', compact('usuario'));
    }

    // Actualizar imagen de perfil
    public function actualizarLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $usuario = Auth::guard('usuario_natural')->user();

        if (!$usuario) {
            return back()->withErrors(['No se encontró el usuario.']);
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // Nombre único del archivo
            $filename = 'perfil_' . $usuario->id_usuario . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

            // Ruta: public/perfiles
            $file->move(public_path('perfiles'), $filename);

            // Guardar ruta accesible directamente
            $usuario->ruta_img_perfil = 'perfiles/' . $filename;
            $usuario->save();

            return redirect()->route('usuario_natural.perfil')->with('success', 'Imagen actualizada correctamente.');
        }

        return redirect()->back()->with('error', 'No se seleccionó ningún archivo.');
    }

    public function mostrarValidarActual()
    {
        return view('auth.validar_actual');
    }

    public function validarActual(Request $request)
    {
        $request->validate([
            'contraseña_actual' => 'required|string',
        ]);

        $usuario = Auth::guard('usuario_natural')->user();

        if (!Hash::check($request->contraseña_actual, $usuario->contraseña)) {
            return back()->withErrors(['contraseña_actual' => 'La contraseña actual no es correcta']);
        }

        // Redirige al formulario para cambiarla
        return redirect()->route('usuario_natural.nueva_contra');
    }

    public function mostrarNuevaContra()
    {
        return view('auth.nueva_contra');
    }

    public function guardarNuevaContra(Request $request)
    {
        $request->validate([
            'nueva_contra' => 'required|string|min:6|confirmed',
        ]);

        $usuario = Auth::guard('usuario_natural')->user();
        if (!$usuario) {
            return back()->withErrors(['No se encontró el usuario autenticado.']);
        }
        $usuario->contraseña = Hash::make($request->nueva_contra);
        $usuario->save();

        return redirect()->route('usuario_natural.perfil')->with('success', 'Contraseña actualizada correctamente.');
    }

}
