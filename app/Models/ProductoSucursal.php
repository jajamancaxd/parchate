<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductoSucursal extends Model
{
    use HasFactory;

    protected $table = 'productos_sucursal';
    protected $primaryKey = 'id_producto_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'nombre_producto_sucursal',
        'precio_producto_sucursal',
        'id_sucursal',
    ];

    /**
     * Relación: un producto pertenece a un evento.
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursales::class, 'id_sucursal', 'id_sucursal');
    }
}