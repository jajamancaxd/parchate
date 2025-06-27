<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoSucursallugaresrecomendados extends Model
{
    protected $table = 'producto_sucursal';
    protected $primaryKey = 'id_producto_sucursal';
    public $timestamps = false;

    public function sucursal()
    {
        return $this->belongsTo(Sucursallugaresrecomendados::class, 'id_sucursal');
    }
}
