<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioSucursal extends Model
{
    protected $table = 'horario_sucursal';
    protected $primaryKey = 'id_horario_sucursal';
    public $timestamps = false;

    protected $fillable = ['id_sucursal', 'id_horarios'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursales::class, 'id_sucursal', 'id_sucursal');
    }

    public function horario()
    {
        return $this->belongsTo(HorarioDeApertura::class, 'id_horarios', 'id_horarios');
    }

    public function diaServicio()
{
    return $this->belongsTo(DiaDeServicio::class, 'id_dia_de_servicio', 'id_dia_de_servicio');
}

}