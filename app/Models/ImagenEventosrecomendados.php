<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenEventosrecomendados extends Model
{
    use HasFactory;

    protected $table = 'imagenes_evento'; // debe ser tu tabla real de imágenes

    protected $fillable = [
        'id_evento',
        'ruta_imagen_evento'
    ];

    public $timestamps = false;

    // Relación inversa
    public function evento()
    {
        return $this->belongsTo(Eventosrecomendados::class, 'id_evento', 'id_evento');
    }
}

