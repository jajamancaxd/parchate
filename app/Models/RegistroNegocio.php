<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class RegistroNegocio extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario_negocio';
    protected $primaryKey = 'id_negocio';
    public $timestamps = false;

    protected $fillable = [
        'nombre_negocio',
        'descripcion_negocio',
        'correo_electronico_negocios',
        'contraseña_negocio', // Asegúrate que coincida con el nombre en la BD
        'ruta_imagne_logo',
        'ruta_documentos_negocios',
        'tipo_de_cuenta',
        'remember_token'
    ];

    protected $hidden = [
        'contraseña_negocio',
        'codigo_confirmacion_correo_negocio',
        'codigo_recuperacion_contraseña_usuario_negocio'
    ];

    /**
     * Get the name of the password attribute for the user.
     * Necesario para que Laravel Auth reconozca tu campo personalizado
     */
    public function getAuthPassword()
    {
        return $this->contraseña_negocio;
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
