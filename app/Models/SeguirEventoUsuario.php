<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguirEventoUsuario extends Model
{
    protected $table = 'seguir_eventos_usuario';
    protected $primaryKey = 'id_seguidos_evento_usuarios';
    public $timestamps = false;

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
