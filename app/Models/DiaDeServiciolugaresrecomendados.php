<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaDeServiciolugaresrecomendados extends Model
{
    protected $table = 'dia_de_servicio';
    protected $primaryKey = 'id_dia_de_servicio';
    public $timestamps = false;

    public function sucursales()
    {
        return $this->hasMany(Sucursallugaresrecomendados::class, 'id_dia_de_servicio');
    }
}
