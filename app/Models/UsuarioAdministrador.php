<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsuarioAdministrador extends Authenticatable
{
    use Notifiable;

    // Nombre de la tabla
    protected $table = 'usuario_administrador';

    // Clave primaria
    protected $primaryKey = 'id';

    // Laravel no usará created_at / updated_at
    public $timestamps = false;

    // Campos que pueden asignarse en masa
    protected $fillable = [
        'nombre_usuario_administrador',
        'numero_documentos_usuario',
        'correo_electronico_administrador',
        'contraseña_administrador',
        'rol_del_administrador',
    ];

    // Campos ocultos (por seguridad)
    protected $hidden = [
        'contraseña_administrador',
    ];

    // Definir qué campo se usa como contraseña para Auth
    public function getAuthPassword()
    {
        return $this->contraseña_administrador;
    }
}
