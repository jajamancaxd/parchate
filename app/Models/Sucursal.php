<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'nombre_sucursal',
        'descripcion_sucursal',
        'ubicacion_dada_sucursal',
        'id_usuario_negocio',
        'id_dia_de_servicio',
        'estado_sucursal',
    ];

    // Relación con imágenes de sucursal
    public function imagenes()
    {
        return $this->hasMany(ImagenSucursal::class, 'id_sucursal');
    }

    // Relación con tipo_de_sucursal_que_tiene_sucursal
    public function tipos()
    {
        return $this->belongsToMany(
            TipoDeSucursal::class,
            'tipo_de_sucursal_que_tiene_sucursal',
            'id_sucursal',
            'id_tipo_sucursal'
        );
    }

    // Relación con día de servicio
    public function dia()
    {
        return $this->belongsTo(DiaDeServicio::class, 'id_dia_de_servicio');
    }

    // Relación con favoritos
    public function favoritos()
    {
        return $this->hasMany(FavoritosSucursalUsuario::class, 'id_sucursales');
    }

    // Relación con usuario negocio
    public function negocio()
    {
        return $this->belongsTo(UsuarioNegocio::class, 'id_usuario_negocio');
    }
}
