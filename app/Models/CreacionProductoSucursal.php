<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreacionProductoSucursal extends Model
{
    protected $table = 'productos_sucursal';
    protected $primaryKey = 'id_producto_sucursal';
    public $timestamps = false;
    protected $fillable = ['nombre_producto_sucursal', 'precio_producto_sucursal', 'id_sucursal'];
}
