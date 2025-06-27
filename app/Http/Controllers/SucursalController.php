<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sucursal;
use App\Models\ImagenSucursal;
use App\Models\DiaDeServicio;


class SucursalController extends Controller
{
    public function negocio()
    {
        $idNegocio = Auth::guard('usuario_negocio')->id();

        $sucursales = Sucursal::with(['imagenes', 'tipos', 'dia', 'favoritos'])
            ->where('id_usuario_negocio', $idNegocio)
            ->get();

        return view('sucursales-negocio', compact('sucursales'));
    }

    public function index(Request $request)
    {
        $query = Sucursal::with(['imagenes', 'dia'])
            ->where('id_usuario_negocio', Auth::guard('usuario_negocio')->id());

        if ($request->has('buscar')) {
            $buscar = $request->input('buscar');
            $query->where('nombre_sucursal', 'like', '%' . $buscar . '%');
        }

        $sucursales = $query->orderBy('fecha_de_creacion', 'desc')->get();

        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
            $diasDeServicio = DiaDeServicio::all();
            return view('sucursales.create', compact('diasDeServicio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'id_dia_de_servicio' => 'required|exists:dia_de_servicio,id_dia_de_servicio',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'etiquetas' => 'nullable|string',
            'horarios' => 'nullable|string',
            'productos' => 'nullable|array',
            'precios' => 'nullable|array',
            'ubicacion' => 'nullable|string',
        ]);

        $productos = $request->productos ?? [];
        $precios = $request->precios ?? [];

        $preciosNumeros = array_filter(array_map('floatval', $precios));
        $promedio = count($preciosNumeros) ? array_sum($preciosNumeros) / count($preciosNumeros) : 0;

        $sucursal = Sucursal::create([
            'nombre_sucursal' => $request->nombre,
            'descripcion_sucursal' => $request->descripcion,
            'ubicacion_dada_sucursal' => $request->ubicacion,
            'promedio_productos' => $promedio,
            'id_dia_de_servicio' => $request->id_dia_de_servicio,
            'id_usuario_negocio' => Auth::guard('usuario_negocio')->id(),
            'estado_sucursal' => 'activa',
            'fecha_de_creacion' => now()
        ]);

        if ($request->hasFile('imagenes')) {
            $orden = 1;
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('sucursales', 'public');

                ImagenSucursal::create([
                    'ruta_imagen_sucursal' => $path,
                    'id_sucursal' => $sucursal->id_sucursal,
                    'imagen_sucursal_orden' => $orden++
                ]);
            }
        }

        return redirect()->route('sucursales.negocio')->with('success', 'Sucursal guardada correctamente.');
    }

    public function show(Sucursal $sucursal)
    {
        $sucursal->load('imagenes', 'dia');
        return view('sucursales.show', compact('sucursal'));
    }

    public function edit(Sucursal $sucursal)
    {
        $sucursal->load('imagenes', 'dia');
        return view('sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'id_dia_de_servicio' => 'required|exists:dia_de_servicio,id_dia_de_servicio',
            'etiquetas' => 'nullable|string',
            'horarios' => 'nullable|string',
            'productos' => 'nullable|array',
            'precios' => 'nullable|array',
            'ubicacion' => 'nullable|string',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $productos = $request->productos ?? [];
        $precios = $request->precios ?? [];

        $preciosNumeros = array_filter(array_map('floatval', $precios));
        $promedio = count($preciosNumeros) ? array_sum($preciosNumeros) / count($preciosNumeros) : 0;

        $sucursal->update([
            'nombre_sucursal' => $request->nombre,
            'descripcion_sucursal' => $request->descripcion,
            'ubicacion_dada_sucursal' => $request->ubicacion,
            'promedio_productos' => $promedio,
            'id_dia_de_servicio' => $request->id_dia_de_servicio,
            'estado_sucursal' => 'activa',
        ]);

        if ($request->hasFile('imagenes')) {
            $orden = ImagenSucursal::where('id_sucursal', $sucursal->id_sucursal)->max('imagen_sucursal_orden') + 1;

            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('sucursales', 'public');

                ImagenSucursal::create([
                    'ruta_imagen_sucursal' => $path,
                    'id_sucursal' => $sucursal->id_sucursal,
                    'imagen_sucursal_orden' => $orden++
                ]);
            }
        }

        return redirect()->route('sucursales.negocio')->with('success', 'Sucursal guardada correctamente.');
    }

    public function destroy(Sucursal $sucursal)
    {   

    \DB::table('favoritos_sucursales_usuarios')
        ->where('id_sucursales', $sucursal->id_sucursal)
        ->delete();


    \DB::table('imagenes_sucursal')
        ->where('id_sucursal', $sucursal->id_sucursal)
        ->delete();

    $sucursal->imagenes()->delete();
    $sucursal->delete();

        return redirect()->route('sucursales.negocio')->with('success', 'Sucursal eliminada correctamente.');
    }
}
