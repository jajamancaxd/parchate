<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    protected $table = 'evento'; // Ajusta si el nombre de la tabla es distinto
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    public function tipos()
    {
        return $this->belongsToMany(
            \App\Models\TipoDeEventos::class,
            'tipo_de_evento_que_tiene_evento',
            'id_evento',
            'id_tipo_evento'
        );
    }

    public function favoritosUsuarios()
    {
        return $this->hasMany(\App\Models\FavoritoEventoUsuario::class,'id_evento','id_evento'
        );
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(\App\Models\ImagenEvento::class, 'id_evento', 'id_evento')
                    ->orderBy('imagen_evento_orden');
    }

    public function imagenes()
    {
        return $this->hasMany(\App\Models\ImagenEvento::class, 'id_evento', 'id_evento')
                    ->orderBy('imagen_evento_orden');
    }

    /**
     * Relación: un evento tiene muchos productos.
     */
    public function productos()
    {
        return $this->hasMany(\App\Models\ProductoEvento::class, 'id_evento', 'id_evento');
    }

    public function usuarioNegocio()
    {
        return $this->belongsTo(\App\Models\UsuarioNegocios::class, 'id_usuario_negocio', 'id_negocio');
    }

}