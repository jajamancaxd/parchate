<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class Restablecer_contraController extends Controller
{
    public function mostrarFormulario()
    {
        return view('auth.restablecer_contra');
    }

    public function enviarCodigo(Request $request)
    {
        $request->validate(['correo' => 'required|email']);
        $correo = $request->correo;
        $codigo = rand(100000, 999999);

        // Buscar en usuario_natural
        $usuario = DB::table('usuario_natural')->where('correo_electronico', $correo)->first();
        if ($usuario) {
            DB::table('usuario_natural')->where('correo_electronico', $correo)
                ->update(['codigo_de_recuperacion_usuario_natural' => $codigo]);

            Mail::raw("Tu código de recuperación es: $codigo", function ($msg) use ($correo) {
                $msg->to($correo)->subject('Código de recuperación');
            });

            return view('auth.confirmar_codigo_contra', ['correo' => $correo, 'tipo' => 'natural']);
        }

        // Buscar en usuario_negocio
        $negocio = DB::table('usuario_negocio')->where('correo_electronico_negocios', $correo)->first();
        if ($negocio) {
            DB::table('usuario_negocio')->where('correo_electronico_negocios', $correo)
                ->update(['codigo_recoperacion_contraseña_usuario_negocio' => $codigo]);

            Mail::raw("Tu código de recuperación es: $codigo", function ($msg) use ($correo) {
                $msg->to($correo)->subject('Código de recuperación');
            });

            return view('auth.confirmar_codigo_contra', ['correo' => $correo, 'tipo' => 'negocio']);
        }

        return back()->withErrors(['correo' => 'La cuenta no existe.']);
    }

    public function validarCodigo(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'tipo' => 'required|in:natural,negocio',
            'codigo' => 'required'
        ]);

        $correo = $request->correo;
        $tipo = $request->tipo;
        $codigo = $request->codigo;

        if ($tipo === 'natural') {
            $usuario = DB::table('usuario_natural')->where('correo_electronico', $correo)->first();
            if ($usuario && $usuario->codigo_de_recuperacion_usuario_natural == $codigo) {
                return view('auth.nueva_contraseña', compact('correo', 'tipo'));
            }
        }

        if ($tipo === 'negocio') {
            $negocio = DB::table('usuario_negocio')->where('correo_electronico_negocios', $correo)->first();
            if ($negocio && $negocio->codigo_recoperacion_contraseña_usuario_negocio == $codigo) {
                return view('auth.nueva_contraseña', compact('correo', 'tipo'));
            }
        }

        // 🔴 Aquí está el cambio implementado correctamente
        return redirect()->route('confirmar.codigo.contra.vista', [
            'correo' => $correo,
            'tipo' => $tipo
        ])->withErrors(['codigo' => 'Código incorrecto.']);
    }

    public function actualizarContraseña(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'tipo' => 'required|in:natural,negocio',
            'nueva_contraseña' => 'required|min:6'
        ]);

        $correo = $request->correo;
        $tipo = $request->tipo;
        $nueva = Hash::make($request->nueva_contraseña);

        if ($tipo === 'natural') {
            DB::table('usuario_natural')->where('correo_electronico', $correo)
                ->update([
                    'contraseña' => $nueva,
                    'codigo_de_recuperacion_usuario_natural' => null
                ]);
        } else {
            DB::table('usuario_negocio')->where('correo_electronico_negocios', $correo)
                ->update([
                    'contraseña_negocio' => $nueva,
                    'codigo_recoperacion_contraseña_usuario_negocio' => null
                ]);
        }

        return redirect()->route('login')->with('success', 'Contraseña actualizada correctamente.');
    }
}
