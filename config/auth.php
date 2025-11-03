// config/auth.php
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

        'superadmin' => [
            'driver' => 'session',
            'provider' => 'superadmins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Tenant\User::class,
        ],

        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Landlord\SuperAdmin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 2,
        ],

        'superadmins' => [
            'provider' => 'superadmins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 2,
        ],
    ],

    'password_timeout' => 10800,
];
