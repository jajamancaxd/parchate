<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorariosDeApertura extends Model
{
    protected $table = 'horarios_de_apertura';
    protected $primaryKey = 'id_horarios';
    public $timestamps = false;

    protected $fillable = [
        'horario',
        'id_sucursal'
    ];
}
