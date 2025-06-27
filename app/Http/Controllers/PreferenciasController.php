<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioTipoEvento;
use App\Models\UsuarioTipoSucursal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PreferenciasController extends Controller
{
    /**
     * Muestra el formulario de preferencias.
     */
    public function mostrarFormulario()
    {
        return view('usuario_primerizo');
    }

    /**
     * Guarda las preferencias seleccionadas por el usuario.
     */
    public function guardarPreferencias(Request $request)
    {
        // Puedes usar Auth::id() si estás autenticando usuarios.
        // $userId = Auth::id();
        $userId = Auth::guard('usuario_natural')->id();

        // Temporalmente usamos un ID fijo para pruebas locales
        // $userId = 22;

        // 🧹 Eliminar preferencias anteriores del usuario (si existen)
        UsuarioTipoSucursal::where('id_usuario', $userId)->delete();
        UsuarioTipoEvento::where('id_usuario', $userId)->delete();

        // ✅ Guardar las preferencias de lugares
        foreach ($request->lugares as $opcion) {
            UsuarioTipoSucursal::create([
                'id_usuario' => $userId,
                'id_tipo_de_sucursal' => $opcion['id'],
                'puntos' => $opcion['puntos']
            ]);
        }

        foreach ($request->eventos as $opcion) {
            UsuarioTipoEvento::create([
                'id_usuario' => $userId,
                'id_tipo_de_evento' => $opcion['id'],
                'puntos' => $opcion['puntos']
            ]);
        }

        // ✅ Marcar al usuario como no primerizo
        DB::table('usuario_natural')
            ->where('id_usuario', $userId)
            ->update(['es_primerizo' => 0]);

        return response()->json([
            'mensaje' => 'Preferencias guardadas con éxito.',
            'redirect' => route('lugares.recomendados') // 👈 redirección al perfil
        ]);
    }
}