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
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin_staff',
        ],
        'staff' => [
            'driver' => 'session',
            'provider' => 'admin_staff',
        ],
        'patient' => [                     // <-- Add this
            'driver' => 'session',
            'provider' => 'patients',     // This must match the provider below
        ],
        'doctor' => [                     // <-- Add this
            'driver' => 'session',
            'provider' => 'doctor',     // This must match the provider below
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'admin_staff' => [
            'driver' => 'eloquent',
            'model' => App\Models\Staff::class,  // This should reference your Patient model
        ],
        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,  // This should reference your Patient model
        ],
        'doctor' => [
            'driver' => 'eloquent',
            'model' => App\Models\Doctor::class,  // This should reference your Patient model
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
