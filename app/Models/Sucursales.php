<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    protected $table = 'sucursal'; // Ajusta si el nombre de la tabla es distinto
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;

    public function tipos()
    {
        return $this->belongsToMany(
            \App\Models\TipoDeSucursal::class,
            'tipo_de_sucursal_que_tiene_sucursal',
            'id_sucursal',
            'id_tipo_sucursal'
        );
    }

    public function favoritosUsuarios()
    {
        return $this->hasMany(\App\Models\FavoritosSucursalUsuario::class,'id_sucursales','id_sucursal'
        );
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(\App\Models\ImagenesSucursales::class, 'id_sucursal', 'id_sucursal')
                    ->orderBy('imagen_sucursal_orden');
    }

    public function imagenes()
    {
        return $this->hasMany(\App\Models\ImagenesSucursales::class, 'id_sucursal', 'id_sucursal')
                    ->orderBy('imagen_sucursal_orden');
    }

    /**
     * Relación: una sucursal tiene muchos productos.
     */
    public function productos()
    {
        return $this->hasMany(\App\Models\ProductoSucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function diaDeServicio()
    {
        return $this->belongsTo(\App\Models\DiaDeServicio::class, 'id_dia_de_servicio', 'id_dia_de_servicio');
    }

    public function horariosSucursal()
    {
     return $this->hasMany(\App\Models\HorarioSucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function usuarioNegocio()
    {
        return $this->belongsTo(\App\Models\UsuarioNegocios::class, 'id_usuario_negocio', 'id_negocio');
    }


}
