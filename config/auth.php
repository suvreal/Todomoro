<?php

return [
    'defaults' => [
        'guard' => env(key: 'AUTH_GUARD', default: 'web'),
        'passwords' => env(key: 'AUTH_PASSWORD_BROKER', default: 'users'),
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env(key: 'AUTH_MODEL', default: App\Models\User::class),
        ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env(
                key: 'AUTH_PASSWORD_RESET_TOKEN_TABLE',
                default: 'password_reset_tokens'
            ),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => env(key: 'AUTH_PASSWORD_TIMEOUT', default: 10800),

];
