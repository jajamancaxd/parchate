<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioTipoSucursal extends Model
{
    protected $table = 'usuario_tipo_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_tipo_de_sucursal',
        'puntos',
    ];
}
