<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioNegocioController extends Controller
{
    public function vista()
    {
        $usuario = [
            'nombre' => 'Company',
            'slogan' => 'Slogan Here',
            'correo' => 'micorreocompany@gmail.com',
            'logo' => 'company-logo.png',
            'ubicacion' => true,
            'notificaciones' => true
        ];

        return view('usuario-negocio', compact('usuario'));
    }
}
