<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoPropio extends Model
{
    use HasFactory;

    protected $table = 'evento'; // Asegúrate que coincide con tu tabla en la BD
    protected $primaryKey = 'id_evento';
    public $timestamps = true; // Habilitado para usar fecha_de_creacion

    protected $fillable = [
        'id_usuario_negocio',
        'nombre_evento',
        'descripcion_evento',
        'tipo_evento',
        'ubicacion_dada_evento',
        'fecha_evento',
        'hora_evento',
        'fecha_de_creacion',
        
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'hora_evento' => 'datetime:H:i',
    ];

    // Relación con imágenes
    public function imagenes()
    {
        return $this->hasMany(ImagenEvento::class, 'id_evento', 'id_evento');
    }
}