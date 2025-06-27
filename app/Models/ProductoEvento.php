<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ProductoEvento.php
class ProductoEvento extends Model {
    protected $table = 'productos_eventos';
    protected $primaryKey = 'id_producto_evento';
    public $timestamps = false;
    protected $fillable = ['nombre_producto_evento', 'precio_producto_evento', 'id_sucursal'];
}