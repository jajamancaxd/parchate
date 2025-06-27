<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoritoEventoUsuarios extends Model
{
    protected $table = 'favoritos_eventos_usuarios';
    protected $primaryKey = 'id_favoritos_eventos_usuarios';
    public $timestamps = false; // Si no tienes columnas created_at y updated_at

    protected $fillable = [
        'id_usuario',
        'id_evento',
    ];
}