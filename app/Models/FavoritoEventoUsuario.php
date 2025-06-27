<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;

class FavoritoEventoUsuario extends Model
{
    protected $table = 'favoritos_eventos_usuarios';
    protected $primaryKey = 'id_favoritos_eventos_usuarios';
    public $timestamps = false;

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }
}
