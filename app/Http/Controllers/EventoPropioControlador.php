<?php

namespace App\Http\Controllers;

use App\Models\EventoPropio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventoPropioControlador extends Controller
{
    // Mostrar todos los eventos del usuario actual
    public function index()
    {
        $eventospropios = EventoPropio::with(['imagenes'])
            ->where('id_usuario_negocio', Auth::id())
            ->orderBy('fecha_de_creacion', 'desc')
            ->get();
            
        return view('evento-propio', compact('eventospropios'));
    }

    // Mostrar un evento propio específico
    public function show($id)
    {
        $evento = EventoPropio::with(['imagenes'])
            ->where('id_usuario_negocio', Auth::id())
            ->findOrFail($id);
            
        return view('evento-propio.show', compact('evento'));
    }

    // Buscar eventos propios por nombre
    public function buscar(Request $request)
    {
        $buscar = $request->input('buscar');

        $eventospropios = EventoPropio::with(['imagenes'])
            ->where('id_usuario_negocio', Auth::id())
            ->where('nombre_evento', 'LIKE', "%{$buscar}%")
            ->orderBy('fecha_de_creacion', 'desc')
            ->get();

        return view('evento-propio', compact('evento-propio', 'buscar'));
    }

    // Mostrar formulario para crear nuevo evento
    public function create()
    {
        return view('eventos.create');
    }

    // Guardar nuevo evento propio
    public function store(Request $request)
    {
        $request->validate([
            'nombre_evento' => 'required|string|max:255',
            'descripcion_evento' => 'required|string',
            'tipo_evento' => 'required|in:deportivos,danza,culturales,exposiciones,conciertos,desfiles,teatro,gastronomicos,tecnologicos,religiosos',
            'ubicacion_dada_evento' => 'required|string',
            'fecha_evento' => 'required|date',
            'hora_evento' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $evento = new EventoPropio();
        $evento->id_usuario_negocio = Auth::id();
        $evento->nombre_evento = $request->nombre_evento;
        $evento->descripcion_evento = $request->descripcion_evento;
        $evento->tipo_evento = $request->tipo_evento;
        $evento->ubicacion_dada_evento = $request->ubicacion_dada_evento;
        $evento->fecha_evento = $request->fecha_evento;
        $evento->hora_evento = $request->hora_evento;
        $evento->save();

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('evento-propio', 'public');
            $evento->imagenes()->create(['ruta_imagen_evento' => $ruta]);
        }

        return redirect()->route('evento-propio.index')
            ->with('success', 'Evento creado correctamente.');
    }

    // Métodos adicionales que podrías necesitar
    public function edit($id)
    {
        $evento = EventoPropio::where('id_usuario_negocio', Auth::id())->findOrFail($id);
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, $id)
    {
        // Implementación de actualización
    }

    public function destroy($id)
    {
        // Implementación de eliminación
    }
}