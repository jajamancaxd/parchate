<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CreacionSucursal;
use App\Models\CreacionImagenSucursal;
use App\Models\CreacionProductoSucursal;
use App\Models\CreacionTipoDeSucursal;
use App\Models\CreacionDiaDeServicio;
use App\Models\HorariosDeApertura;

class CreacionSucursalController extends Controller
{
    public function index()
    {
        $idNegocio = Auth::guard('usuario_negocio')->id();
        $sucursales = CreacionSucursal::with('imagenesSucursal')->where('id_usuario_negocio', $idNegocio)->get();
        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        $tipos = CreacionTipoDeSucursal::all();
        $dias = CreacionDiaDeServicio::all();
        return view('sucursales.create', compact('tipos', 'dias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_sucursal' => 'required|string|max:255',
            'descripcion_sucursal' => 'required|string|max:255',
            'ubicacion_dada_sucursal' => 'required|string|max:255',
            'dia_de_servicio' => 'required|exists:dia_de_servicio,id_dia_de_servicio',
            'tipo_sucursal' => 'required|array|min:1',
            'tipo_sucursal.*' => 'exists:tipo_de_sucursal,id_tipo_de_sucursal',
            'imagen_principal' => 'required|image',
            'imagenes_muestra.*' => 'image',
            'productos' => 'required|array|min:1',
            'productos.*.nombre' => 'required|string|max:255',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $sucursal = CreacionSucursal::create([
                'nombre_sucursal' => $request->nombre_sucursal,
                'descripcion_sucursal' => $request->descripcion_sucursal,
                'ubicacion_dada_sucursal' => $request->ubicacion_dada_sucursal,
                'id_dia_de_servicio' => $request->dia_de_servicio,
                'id_usuario_negocio' => Auth::guard('usuario_negocio')->id(),
                'estado_sucursal' => 'en espera',
                'fecha_de_creacion' => now(),
            ]);

            // Imagen principal
            $principalPath = $request->file('imagen_principal')->store('sucursales', 'public');
            CreacionImagenSucursal::create([
                'ruta_imagen_sucursal' => $principalPath,
                'id_sucursal' => $sucursal->id_sucursal,
                'imagen_sucursal_orden' => 'principal',
            ]);

            // Imágenes de muestra
            if ($request->hasFile('imagenes_muestra')) {
                foreach ($request->file('imagenes_muestra') as $key => $imagen) {
                    $path = $imagen->store('sucursales', 'public');
                    CreacionImagenSucursal::create([
                        'ruta_imagen_sucursal' => $path,
                        'id_sucursal' => $sucursal->id_sucursal,
                        'imagen_sucursal_orden' => 'muestra_' . $key,
                    ]);
                }
            }

            // Tipos de sucursal (etiquetas)
            $sucursal->tipos()->attach($request->tipo_sucursal);

            // Productos y promedio
            $total = 0;
            foreach ($request->productos as $producto) {
                CreacionProductoSucursal::create([
                    'nombre_producto_sucursal' => $producto['nombre'],
                    'precio_producto_sucursal' => $producto['precio'],
                    'id_sucursal' => $sucursal->id_sucursal,
                ]);
                $total += $producto['precio'];
            }
            $promedio = round($total / count($request->productos));
            $sucursal->update(['promedio_productos' => $promedio]);

            DB::commit();
            return redirect()->route('sucursales.index')->with('success', 'Sucursal creada exitosamente y está en revisión.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la sucursal: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $sucursal = CreacionSucursal::with(['imagenesSucursal', 'productos', 'tipos'])->findOrFail($id);
        $tipos = CreacionTipoDeSucursal::all();
        $dias = CreacionDiaDeServicio::all();

        return view('sucursales.edit', compact('sucursal', 'tipos', 'dias'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_sucursal' => 'required|string|max:255',
            'descripcion_sucursal' => 'required|string|max:255',
            'ubicacion_dada_sucursal' => 'required|string|max:255',
            'dia_de_servicio' => 'required|exists:dia_de_servicio,id_dia_de_servicio',
            'tipo_sucursal' => 'required|array|min:1',
            'tipo_sucursal.*' => 'exists:tipo_de_sucursal,id_tipo_de_sucursal',
            'productos' => 'required|array|min:1',
            'productos.*.nombre' => 'required|string|max:255',
            'productos.*.precio' => 'required|numeric|min:0',
            'horario_de_servicio' => 'required|string',
        ]);

        $sucursal = CreacionSucursal::findOrFail($id);

        $sucursal->update([
            'nombre_sucursal' => $request->nombre_sucursal,
            'descripcion_sucursal' => $request->descripcion_sucursal,
            'ubicacion_dada_sucursal' => $request->ubicacion_dada_sucursal,
            'id_dia_de_servicio' => $request->dia_de_servicio,
        ]);

        // Actualizar tipos
        $sucursal->tipos()->sync($request->tipo_sucursal);

        // Actualizar productos
        $sucursal->productos()->delete();
        $total = 0;
        foreach ($request->productos as $producto) {
            CreacionProductoSucursal::create([
                'nombre_producto_sucursal' => $producto['nombre'],
                'precio_producto_sucursal' => $producto['precio'],
                'id_sucursal' => $sucursal->id_sucursal,
            ]);
            $total += $producto['precio'];
        }

        $promedio = round($total / count($request->productos));
        $sucursal->update(['promedio_productos' => $promedio]);

        // Actualizar horario
        HorariosDeApertura::updateOrCreate(['id_sucursal' => $sucursal->id_sucursal], ['horario' => $request->horario_de_servicio]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada correctamente.');
    }
}
