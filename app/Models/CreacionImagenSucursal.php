<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreacionImagenSucursal extends Model
{
    protected $table = 'imagenes_sucursal';
    protected $primaryKey = 'id_imagen_sucursal';
    public $timestamps = false;
    protected $fillable = ['ruta_imagen_sucursal', 'id_sucursal', 'imagen_sucursal_orden'];

    public function sucursal() {
        return $this->belongsTo(CreacionSucursal::class, 'id_sucursal', 'id_sucursal');
    }
}
