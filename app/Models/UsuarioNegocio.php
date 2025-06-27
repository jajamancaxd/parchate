<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UsuarioNegocio extends Authenticatable
{
    protected $table = 'usuario_negocio';
    protected $primaryKey = 'id_negocio';
    public $timestamps = false;

    protected $fillable = [
        'nombre_negocio',
        'correo_electronico_negocios',
        'ruta_imagne_logo',
    ];

    public function getAuthPassword()
    {
        return $this->contraseña_negocio;
    }
}
