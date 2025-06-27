<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioNegocios extends Model
{
    protected $table = 'usuario_negocio';
    protected $primaryKey = 'id_negocio';
    public $timestamps = false;

    /**
     * Relación: un negocio tiene muchas sucursales.
     */
    public function sucursales()
    {
        return $this->hasMany(\App\Models\Sucursales::class, 'id_usuario_negocio', 'id_negocio');
    }

    /**
     * Relación: un negocio tiene muchos eventos.
     */
    public function eventos()
    {
        return $this->hasMany(\App\Models\Eventos::class, 'id_usuario_negocio', 'id_negocio');
    }

    

}
