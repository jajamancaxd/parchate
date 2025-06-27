<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreacionTipoDeSucursal extends Model
{
    protected $table = 'tipo_de_sucursal';
    protected $primaryKey = 'id_tipo_de_sucursal';
    public $timestamps = false;
    protected $fillable = ['tipo_de_sucursal'];
}
