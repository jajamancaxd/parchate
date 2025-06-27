<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioTipoEvento extends Model
{
    protected $table = 'usuario_tipo_evento';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_tipo_de_evento',
        'puntos',
    ];
}

