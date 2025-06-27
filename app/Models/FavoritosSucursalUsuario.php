<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sucursal;

class FavoritosSucursalUsuario extends Model
{
    protected $table = 'favoritos_sucursales_usuarios';
    protected $primaryKey = 'id_favoritos_sucursales_usuarios';
    public $timestamps = false;

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursales', 'id_sucursal');
    }
}
