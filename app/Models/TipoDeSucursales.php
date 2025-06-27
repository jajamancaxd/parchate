<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDeSucursales extends Model
{
    protected $table = 'tipo_de_sucursal'; // Nombre correcto de la tabla
    protected $primaryKey = 'id_tipo_de_sucursal'; // Clave primaria personalizada
    public $timestamps = false;

    public function sucursales()
{
    return $this->belongsToMany(
        \App\Models\Sucursales::class,
        'tipo_de_sucursal_que_tiene_sucursal',
        'id_tipo_sucursal',
        'id_sucursal'
    );
}
}