<?php

// Evento.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'evento';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_evento', 'descripcion_evento', 'fecha_inicio_evento',
        'hora_inicio_evento', 'presupuesto_evento', 'id_usuario_negocio',
        'estado_evento', 'fecha_de_creacion', 'ubicacion_dada_evento',
    ];

    public function imagenes() {
        return $this->hasMany(ImagenEvento::class, 'id_evento');
    }

    public function tipos() {
        return $this->belongsToMany(TipoDeEvento::class, 'tipo_de_evento_que_tiene_evento', 'id_evento', 'id_tipo_evento');
    }

    public function productos() {
        return $this->hasMany(ProductoEvento::class, 'id_sucursal'); // Revisa si `productos_eventos` debería apuntar a `evento` y corrige si es necesario
    }
}