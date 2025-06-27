<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDeSucursallugaresrecomendados extends Model
{
    protected $table = 'tipo_de_sucursal';
    protected $primaryKey = 'id_tipo_sucursal';
    public $timestamps = false;

    public function sucursales()
    {
        return $this->belongsToMany(
            Sucursallugaresrecomendados::class,
            'tipo_de_sucursal_que_tiene_sucursal',
            'id_tipo_sucursal',
            'id_sucursal'
        );
    }
}

