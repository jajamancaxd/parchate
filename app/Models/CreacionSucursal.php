<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreacionSucursal extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;
    protected $fillable = [
        'nombre_sucursal', 'descripcion_sucursal', 'ubicacion_dada_sucursal', 'longitud', 'latitud', 'promedio_productos', 'id_dia_de_servicio', 'id_usuario_negocio', 'estado_sucursal', 'fecha_de_creacion'
    ];

    public function imagenesSucursal() {
        return $this->hasMany(CreacionImagenSucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function productos() {
        return $this->hasMany(CreacionProductoSucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function tipos() {
        return $this->belongsToMany(CreacionTipoDeSucursal::class, 'tipo_de_sucursal_que_tiene_sucursal', 'id_sucursal', 'id_tipo_sucursal', 'id_sucursal', 'id_tipo_de_sucursal');
    }

    public function diaServicio() {
        return $this->belongsTo(CreacionDiaDeServicio::class, 'id_dia_de_servicio', 'id_dia_de_servicio');
    }
}
