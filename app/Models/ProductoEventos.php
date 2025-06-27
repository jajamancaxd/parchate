<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoEventos extends Model
{
    use HasFactory;

    protected $table = 'productos_eventos';
    protected $primaryKey = 'id_producto_evento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_producto_evento',
        'precio_producto_evento',
        'id_evento',
    ];

    /**
     * Relación: un producto pertenece a un evento.
     */
    public function evento()
    {
        return $this->belongsTo(Eventos::class, 'id_evento', 'id_evento');
    }
}