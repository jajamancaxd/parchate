<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'usuario_natural' => [
            'driver' => 'session',
            'provider' => 'usuarios_naturales',
        ],

        'usuario_negocio' => [ // 👈 nuevo guard
            'driver' => 'session',
            'provider' => 'usuarios_negocios',
        ],
            'usuario_administrador' => [ // 👈 nuevo guard
            'driver' => 'session',
            'provider' => 'administradores',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        'usuarios_naturales' => [
            'driver' => 'eloquent',
            'model' => App\Models\UsuarioNatural::class,
        ],

        'usuarios_negocios' => [ // 👈 nuevo provider
            'driver' => 'eloquent',
            'model' => App\Models\UsuarioNegocio::class,
        ],
            'administradores' => [ // 👈 nuevo provider
            'driver' => 'eloquent',
            'model' => App\Models\UsuarioAdministrador::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
