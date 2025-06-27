<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// TipoDeEvento.php
class TipoDeEvento extends Model {
    protected $table = 'tipo_de_evento';
    protected $primaryKey = 'id_tipo_evento';
    public $timestamps = false;
    protected $fillable = ['tipo_de_evento'];
}