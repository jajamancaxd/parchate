<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ImagenSucursallugaresrecomendados;
use App\Models\ProductoSucursallugaresrecomendados;
use App\Models\DiaDeServiciolugaresrecomendados;
use App\Models\TipoDeSucursallugaresrecomendados;

class Sucursallugaresrecomendados extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;

    public function imagenes()
    {
        return $this->hasMany(ImagenSucursallugaresrecomendados::class, 'id_sucursal', 'id_sucursal');
    }

    public function productos()
    {
        return $this->hasMany(ProductoSucursallugaresrecomendados::class, 'id_sucursal');
    }

    public function dia()
    {
        return $this->belongsTo(DiaDeServiciolugaresrecomendados::class, 'id_dia_de_servicio');
    }

    public function tipos()
    {
        return $this->belongsToMany(
            TipoDeSucursallugaresrecomendados::class,
            'tipo_de_sucursal_que_tiene_sucursal',
            'id_sucursal',
            'id_tipo_sucursal'
        );
    }
}
