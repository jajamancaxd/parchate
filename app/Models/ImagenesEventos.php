<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenesEventos extends Model
{
    protected $table = 'imagenes_evento';
    protected $primaryKey = 'id_imagen_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'ruta_imagen_evento',
        'id_evento',
        'imagen_evento_orden',
    ];

    // Relación inversa (opcional)
    public function evento()
    {
        return $this->belongsTo(\App\Models\Eventos::class, 'id_evento', 'id_evento');
    }
}