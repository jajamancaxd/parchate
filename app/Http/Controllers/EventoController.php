<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\ImagenEvento;
use App\Models\ProductoEvento;
use App\Models\TipoDeEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    public function index() {
        $eventos = Evento::with('imagenes')->get();
        return view('eventos.index', compact('eventos'));
    }

    public function create() {
        $tipos = TipoDeEvento::all();
        return view('eventos.create', compact('tipos'));
    }

    public function store(Request $request) {
        $request->validate([
            'nombre_evento' => 'required|string',
            'descripcion_evento' => 'required|string',
            'imagen_portada' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'imagenes_muestra.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tipos_evento' => 'required|array',
            'productos' => 'required|array',
            'productos.*.nombre' => 'required|string',
            'productos.*.precio' => 'required|numeric|min:0',
            'fecha_inicio_evento' => 'required|date',
            'hora_inicio_evento' => 'required',
            'ubicacion_dada_evento' => 'required|string'
        ]);

        DB::transaction(function () use ($request) {
            $evento = Evento::create([
                'nombre_evento' => $request->nombre_evento,
                'descripcion_evento' => $request->descripcion_evento,
                'fecha_inicio_evento' => $request->fecha_inicio_evento,
                'hora_inicio_evento' => $request->hora_inicio_evento,
                'ubicacion_dada_evento' => $request->ubicacion_dada_evento,
                'fecha_de_creacion' => now(),
                'id_usuario_negocio' => Auth::guard('usuario_negocio')->id()
            ]);

            if ($request->hasFile('imagen_portada')) {
                $path = $request->file('imagen_portada')->store('public/eventos');
                ImagenEvento::create([
                    'id_evento' => $evento->id_evento,
                    'ruta_imagen_evento' => str_replace('public/', '', $path),
                    'imagen_evento_orden' => 'principal'
                ]);
            }

            if ($request->hasFile('imagenes_muestra')) {
                foreach ($request->file('imagenes_muestra') as $i => $img) {
                    $path = $img->store('public/eventos');
                    ImagenEvento::create([
                        'id_evento' => $evento->id_evento,
                        'ruta_imagen_evento' => str_replace('public/', '', $path),
                        'imagen_evento_orden' => "muestra_$i"
                    ]);
                }
            }

            $evento->tipos()->attach($request->tipos_evento);

            foreach ($request->productos as $producto) {
                ProductoEvento::create([
                    'nombre_producto_evento' => $producto['nombre'],
                    'precio_producto_evento' => $producto['precio'],
                    'id_sucursal' => null
                ]);
            }
        });

        return redirect()->route('eventos.index')->with('success', 'Evento creado y enviado a revisión.');
    }

    public function edit(Evento $evento) {
        $tipos = TipoDeEvento::all();
        $evento->load('tipos', 'imagenes', 'productos');
        return view('eventos.edit', compact('evento', 'tipos'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre_evento' => 'required|string',
            'descripcion_evento' => 'required|string',
            'imagen_portada' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'imagenes_muestra.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tipos_evento' => 'required|array',
            'productos' => 'required|array',
            'productos.*.nombre' => 'required|string',
            'productos.*.precio' => 'required|numeric|min:0',
            'fecha_inicio_evento' => 'required|date',
            'hora_inicio_evento' => 'required',
            'ubicacion_dada_evento' => 'required|string'
        ]);

        DB::transaction(function () use ($request, $evento) {
            // ✅ Actualizar los campos del evento
            $evento->update([
                'nombre_evento' => $request->nombre_evento,
                'descripcion_evento' => $request->descripcion_evento,
                'fecha_inicio_evento' => $request->fecha_inicio_evento,
                'hora_inicio_evento' => $request->hora_inicio_evento,
                'ubicacion_dada_evento' => $request->ubicacion_dada_evento,
            ]);

            // ✅ Imagen de portada (opcional)
            if ($request->hasFile('imagen_portada')) {
                $path = $request->file('imagen_portada')->store('public/eventos');
                ImagenEvento::create([
                    'id_evento' => $evento->id_evento,
                    'ruta_imagen_evento' => str_replace('public/', '', $path),
                    'imagen_evento_orden' => 'principal'
                ]);
            }

            // ✅ Imágenes adicionales
            if ($request->hasFile('imagenes_muestra')) {
                foreach ($request->file('imagenes_muestra') as $i => $img) {
                    $path = $img->store('public/eventos');
                    ImagenEvento::create([
                        'id_evento' => $evento->id_evento,
                        'ruta_imagen_evento' => str_replace('public/', '', $path),
                        'imagen_evento_orden' => "muestra_$i"
                    ]);
                }
            }

            // ✅ Etiquetas
            $evento->tipos()->sync($request->tipos_evento);

            // ✅ Eliminar y recrear productos
            ProductoEvento::where('id_sucursal', null)->delete(); // ← Solo si no tienes id_evento

            foreach ($request->productos as $producto) {
                ProductoEvento::create([
                    'nombre_producto_evento' => $producto['nombre'],
                    'precio_producto_evento' => $producto['precio'],
                    'id_sucursal' => null
                ]);
            }
        });

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

}

