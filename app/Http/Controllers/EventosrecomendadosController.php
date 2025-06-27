<?php

namespace App\Http\Controllers;

use App\Models\Eventosrecomendados;
use Illuminate\Http\Request;

class EventosrecomendadosController extends Controller
{
    // Mostrar todos los eventos
    public function index()
    {
        $Eventos = Eventosrecomendados::with('imagenes')->get();
        return view('eventosrecomendados', compact('Eventos'));
    }

    // Mostrar un evento por ID
    public function show($id)
    {
        $evento = Eventosrecomendados::with('imagenes')->findOrFail($id);
        return view('eventos.showeventosrecomendados', compact('evento'));
    }

    // Buscar eventos por nombre
    public function buscar(Request $request)
    {
        $buscar = $request->input('buscar');

        $Eventos = Eventosrecomendados::with('imagenes')
            ->where('nombre_evento', 'LIKE', "%{$buscar}%")
            ->get();

        return view('index', compact('Eventos', 'buscar'));
    }

    // Mostrar formulario de crear evento
    public function create()
    {
        return view('crear');
    }

    // Guardar evento y su imagen
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre_evento' => 'required',
            'descripcion_evento' => 'required',
            'ubicacion_dada_evento' => 'required',
            'presupuesto_evento' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Crear evento
        $evento = new Eventosrecomendados();
        $evento->nombre_evento = $request->nombre_evento;
        $evento->descripcion_evento = $request->descripcion_evento;
        $evento->ubicacion_dada_evento = $request->ubicacion_dada_evento;
        $evento->presupuesto_evento = $request->presupuesto_evento; // Usa el valor del formulario
        $evento->save();

        // Subir la imagen
        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('eventos', 'public');

            // Guardar la imagen relacionada
            $evento->imagenes()->create([
                'ruta_imagen_evento' => $ruta
            ]);
        }

        return redirect()->route('evento.index')->with('success', 'Evento creado correctamente.');
    }
}
