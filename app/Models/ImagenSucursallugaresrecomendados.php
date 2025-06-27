<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenSucursallugaresrecomendados extends Model
{
    protected $table = 'imagenes_sucursal';
    protected $primaryKey = 'id_imagen_sucursal';
    public $timestamps = false;

    protected $fillable = ['ruta_imagen_sucursal', 'id_sucursal'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursallugaresrecomendados::class, 'id_sucursal', 'id_sucursal');
    }
}
