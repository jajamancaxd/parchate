<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos;

class EventosController extends Controller
// EventosController.php
{
public function index(Request $request)
{
    $orden = $request->get('orden', 'desc'); // por defecto: descendente
    
    $eventos = Eventos::with([
        'imagenPrincipal', 
        'favoritosUsuarios',
        'tipos'
    ])
    ->withCount('favoritosUsuarios')
    ->where('estado_evento', 'en espera') // Solo los que están en espera
    ->orderBy('fecha_de_creacion', $orden)
    ->get();

    return view('Eventos_admin.Eventos', compact('eventos'));
}


public function show($id)
{
    $evento = \App\Models\Eventos::with([
        'imagenes',
        'productos',
        'favoritosUsuarios',
        'tipos', // solo si quieres mostrar los tipos del evento
    ])
    ->withCount('favoritosUsuarios')
    ->findOrFail($id);

    return view('Eventos_admin.Show', compact('evento'));
}


public function cambiarEstado(Request $request, $id)
{
    $evento = Eventos::findOrFail($id);
    $estado = $request->input('estado');

    // Validación opcional
    if (!in_array($estado, ['aceptado', 'rechazado'])) {
        return redirect()->route('Eventos')->with('error', 'Estado inválido.');
    }

    $evento->estado_evento = $estado;
    $evento->save();

    // Mensaje según estado
    $mensaje = $estado === 'aceptado'
        ? '✅ Aceptaste el evento: ' . $evento->nombre_evento
        : '❌ Rechazaste el evento: ' . $evento->nombre_evento;

    return redirect()->route('Eventos')->with($estado === 'aceptado' ? 'success' : 'error', $mensaje);
}






}
