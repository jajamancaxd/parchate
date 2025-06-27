<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDeEventos extends Model
{
    protected $table = 'tipo_de_evento'; // Nombre correcto de la tabla
    protected $primaryKey = 'id_tipo_evento'; // Clave primaria personalizada
    public $timestamps = false;

    public function eventos()
{
    return $this->belongsToMany(
        \App\Models\Eventos::class,
        'tipo_de_evento_que_tiene_evento',
        'id_tipo_evento',
        'id_evento'
    );
}


}