<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaDeServicio extends Model
{
    protected $table = 'dia_de_servicio';
    protected $primaryKey = 'id_dia_de_servicio';
    public $timestamps = false;

    protected $fillable = ['dias_de_servicios'];

    public function sucursales()
    {
        return $this->hasMany(Sucursales::class, 'id_dia_de_servicio', 'id_dia_de_servicio');
    }
}
