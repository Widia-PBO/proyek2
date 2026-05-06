<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'petugas' => [
            'driver' => 'session',
            'provider' => 'petugas',
        ],
        'pedagang' => [ // Tambahkan satpam untuk pedagang[cite: 15]
            'driver' => 'session',
            'provider' => 'pedagangs',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Petugas::class,
        ],
        'pedagangs' => [ // Sumber data tabel pedagangs[cite: 15]
            'driver' => 'eloquent',
            'model' => App\Models\Pedagang::class,
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
];