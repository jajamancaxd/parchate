<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class VerificacionService
{
    public function __construct()
    {
        // Constructor vacío para inyección automática
    }

    public function generarCodigo()
    {
        return rand(100000, 999999);
    }

    public function enviarCorreo($correo, $codigo)
    {
        Mail::raw("Tu código de confirmación es: $codigo", function ($message) use ($correo) {
            $message->to($correo)
                    ->subject('Código de Confirmación');
        });
    }
}
