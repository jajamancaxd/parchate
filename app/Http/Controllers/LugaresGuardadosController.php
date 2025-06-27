<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FavoritosSucursalUsuario;

class LugaresGuardadosController extends Controller
{
    public function index()
    {
        $sucursales = FavoritosSucursalUsuario::with(['sucursal.imagenes'])
            ->where('id_usuario', auth()->id())
            ->get();

        return view('lugares-guardados', compact('sucursales'));
    }
}
