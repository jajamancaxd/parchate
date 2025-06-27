<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoritoEventoUsuario;

class EventoGuardadoController extends Controller
{
    public function index(Request $request)
    {
        $usuarioId = auth()->id(); 

        $buscar = $request->input('buscar');
        $orden = $request->input('orden', 'desc');

        $eventos = FavoritoEventoUsuario::with(['evento', 'evento.imagenes'])
            ->where('id_usuario', $usuarioId)
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('evento', function ($q) use ($buscar) {
                    $q->where('nombre_evento', 'like', "%$buscar%");
                });
            })
            ->orderByDesc('id_favoritos_eventos_usuarios')
            ->get();

        return view('eventos-guardados', compact('eventos', 'buscar', 'orden'));
    }
}
