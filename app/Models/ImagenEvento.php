<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ImagenEvento.php
class ImagenEvento extends Model {
    protected $table = 'imagenes_evento';
    protected $primaryKey = 'id_imagen';
    public $timestamps = false;
    protected $fillable = ['ruta_imagen_evento', 'id_evento', 'imagen_evento_orden'];

    public function evento() {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}