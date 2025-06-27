<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsuarioNatural extends Authenticatable
{
    protected $table = 'usuario_natural';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;
    protected $keyType = 'int'; 

    protected $fillable = [
        'correo_electronico',
        'contraseña',
        'tipo_de_cuenta',
        'codigo_de_recuperacion_usuario_natural',
        'codigo_de_confirmacion_correo_electronico',
        'ruta_img_perfil',
        'longitud',
        'latitud',
        'es_primerizo',
    ];
}