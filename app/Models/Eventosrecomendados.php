<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventosrecomendados extends Model
{


    protected $table = 'evento'; 
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    public function imagenes()
    {
        return $this->hasMany(ImagenEventosrecomendados::class, 'id_evento', 'id_evento');
    }
}


