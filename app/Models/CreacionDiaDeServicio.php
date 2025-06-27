<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreacionDiaDeServicio extends Model
{
    protected $table = 'dia_de_servicio';
    protected $primaryKey = 'id_dia_de_servicio';
    public $timestamps = false;
    protected $fillable = ['dias_de_servicios'];
}
