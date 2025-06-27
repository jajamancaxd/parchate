<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioDeApertura extends Model
{
    protected $table = 'horarios_de_apertura';
    protected $primaryKey = 'id_horarios';
    public $timestamps = false;

    protected $fillable = ['horario', 'id_sucursal'];

    public function sucursales()
    {
        return $this->hasMany(HorarioSucursal::class, 'id_horarios', 'id_horarios');
    }
}
