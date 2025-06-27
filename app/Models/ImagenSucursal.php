<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenSucursal extends Model
{
    use HasFactory;

    protected $table = 'imagenes_sucursal';
    protected $primaryKey = 'id_imagen_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'ruta_imagen_sucursal',
        'id_sucursal',
        'imagen_sucursal_orden',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    // --- MÉTODOS ADICIONALES DESDE LA OTRA VERSIÓN ---
}
