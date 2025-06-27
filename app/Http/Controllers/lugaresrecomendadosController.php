<?php

namespace App\Http\Controllers;

use App\Models\Sucursallugaresrecomendados;
use App\Models\ImagenSucursallugaresrecomendados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LugaresRecomendadosController extends Controller
{
    // Mostrar todas las sucursales
    public function index(Request $request)
    {
        $query = Sucursallugaresrecomendados::with('imagenes');

        if ($request->filled('ubicacion')) {
            $query->where('ubicacion_dada_sucursal', 'like', '%' . $request->ubicacion . '%');
        }

        if ($request->filled('presupuesto')) {
            $query->whereHas('productos', function ($q) use ($request) {
                $q->where('precio_producto_sucursal', '<=', $request->presupuesto);
            });
        }

        if ($request->filled('dia')) {
            $query->whereHas('dia', function ($q) use ($request) {
                $q->where('dias_de_servicios', $request->dia);
            });
        }

        if ($request->filled('tipo')) {
            $query->whereHas('tipos', function ($q) use ($request) {
                $q->where('tipo_de_sucursal', $request->tipo);
            });
        }

        $sucursales = $query->get();

        return view('lugaresrecomendados', compact('sucursales'));
    }

    public function show($id)
    {
        $sucursal = Sucursallugaresrecomendados::with('imagenes')->findOrFail($id);
        return view('sucursales.showlugaresrecomendados', compact('sucursal'));
    }

    // Buscar sucursales por nombre
    public function buscar(Request $request)
    {
        $buscar = $request->input('buscar');

        $sucursales = Sucursallugaresrecomendados::with('imagenes')
            ->where('nombre_sucursal', 'LIKE', "%{$buscar}%")
            ->get();

        return view('lugaresrecomendados', compact('sucursales', 'buscar'));
    }

    // Mostrar formulario de crear sucursal
    public function create()
    {
        return view('crear');
    }

    // Guardar la sucursal y la imagen
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombre_sucursal' => 'required',
            'descripcion_sucursal' => 'required',
            'ubicacion_dada_sucursal' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Crear la sucursal
        $sucursal = new Sucursallugaresrecomendados();
        $sucursal->nombre_sucursal = $request->nombre_sucursal;
        $sucursal->descripcion_sucursal = $request->descripcion_sucursal;
        $sucursal->ubicacion_dada_sucursal = $request->ubicacion_dada_sucursal;
        $sucursal->promedio_productos = rand(100, 1000);
        $sucursal->save();

        // Subir la imagen
        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('lugares', 'public');

            // Guardar la imagen relacionada a la sucursal
            $imagen = new ImagenSucursallugaresrecomendados();
            $imagen->ruta_imagen_sucursal = $ruta;
            $imagen->id_sucursal = $sucursal->id_sucursal;
            $imagen->imagen_sucursal_orden = 1;
            $imagen->save();
        }

        return redirect()->route('inicio')->with('success', 'Sucursal creada correctamente.');
    }

    // Mostrar lugares recomendados
    public function lugaresRecomendados()
    {
        $sucursales = Sucursallugaresrecomendados::with('imagenes')->get();

        return view('lugaresrecomendados', compact('sucursales'));
    }
}
