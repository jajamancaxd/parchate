<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursales;

class LugaresController extends Controller
{
    public function index(Request $request)
{
    $orden = $request->get('orden', 'desc'); // por defecto: descendente

    $sucursales = Sucursales::with([
        'imagenPrincipal',
        'favoritosUsuarios',
        'tipos',
        'horariosSucursal.horario'
    ])
    ->withCount('favoritosUsuarios')
    ->where('estado_sucursal', 'en espera')
    ->orderBy('fecha_de_creacion', $orden)
    ->get();

    return view('Lugares.Lugares', compact('sucursales'));
}




public function show($id)
{
    $sucursal = Sucursales::with([
        'imagenes',
        'favoritosUsuarios',
        'tipos',
        'horariosSucursal.horario',      // Horario (hora apertura y cierre)
        'horariosSucursal.diaServicio'   // Días de servicio (lunes, martes, etc.)
    ])
    ->withCount('favoritosUsuarios')
    ->findOrFail($id);

    return view('Lugares.Show', compact('sucursal'));
}



public function cambiarEstado(Request $request, $id)
{
    $sucursal = Sucursales::findOrFail($id);
    $estado = $request->input('estado');

    // Validación opcional
    if (!in_array($estado, ['aceptado', 'rechazado'])) {
        return redirect()->route('Lugares')->with('error', 'Estado inválido.');
    }

    $sucursal->estado_sucursal = $estado;
    $sucursal->save();

    // Mensaje según estado
    $mensaje = $estado === 'aceptado'
        ? '✅ Aceptaste el lugar: ' . $sucursal->nombre_sucursal
        : '❌ Rechazaste el lugar: ' . $sucursal->nombre_sucursal;

    return redirect()->route('Lugares')->with($estado === 'aceptado' ? 'success' : 'error', $mensaje);
}

}
