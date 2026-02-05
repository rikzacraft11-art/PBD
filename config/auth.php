<?php

return [

    'defaults' => [
        'guard' => 'web', // Tetap gunakan web sebagai default aplikasi
        'passwords' => 'users',
    ],

    'guards' => [
        // Guard untuk Peserta (Web)
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Guard untuk Admin - Digabung di sini, jangan dipisah!
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        // Provider untuk Peserta
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Peserta::class,
        ],

        // Provider untuk Admin - Digabung di sini
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];