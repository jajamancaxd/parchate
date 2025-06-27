<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioNegocios;

class NegociosController extends Controller
{
    public function index()
    {
        // Obtener todos los negocios que estén en estado 'en espera'
        $negocios = UsuarioNegocios::where('estado_de_cuenta_negocio', 'en espera')->get();

        return view('Negocios.Negocios', compact('negocios'));
    }

    public function show($id)
    {
        $negocio = UsuarioNegocios::findOrFail($id);
        return view('Negocios.Show', compact('negocio'));
    }

    public function cambiarEstado(Request $request, $id)
    {
        $negocio = UsuarioNegocios::findOrFail($id);
        $estado = $request->input('estado');

        if (!in_array($estado, ['aceptada', 'rechazada'])) {
            return redirect()->route('Negocios')->with('error', 'Estado inválido.');
        }

        $negocio->estado_de_cuenta_negocio = $estado;
        $negocio->save();

        $mensaje = $estado === 'aceptada'
            ? '✅ Aceptaste el negocio: ' . $negocio->nombre_negocio
            : '❌ Rechazaste el negocio: ' . $negocio->nombre_negocio;

        return redirect()->route('Negocios')->with($estado === 'aceptada' ? 'success' : 'error', $mensaje);
    }

    public function descargarDocumento($archivo)
    {
        $ruta = storage_path('app/docs/' . $archivo);

        if (!file_exists($ruta)) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->download($ruta);
    }
}