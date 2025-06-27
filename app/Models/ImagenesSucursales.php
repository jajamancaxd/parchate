<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenesSucursales extends Model
{
     protected $table = 'imagenes_sucursal';
    protected $primaryKey = 'id_imagen';
    public $timestamps = false;

    protected $fillable = [
        'ruta_imagen_sucursal',
        'id_sucursal',
        'imagen_sucursal_orden',
    ];

    // Relación inversa (opcional)
    public function sucursal()
    {
        return $this->belongsTo(\App\Models\Sucursales::class, 'id_sucursal', 'id_sucursal');
    }
}