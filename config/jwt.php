<?php

return [
    'access_token_expires_in' => env('JWT_TOKEN_EXPIRES_IN', 1800),
    'refresh_token_expires_in' => env('JWT_REFRESH_TOKEN_EXPIRES_IN', 604800),
    'secret' => env('JWT_SECRET', '{very secret key}'),
    'rsa' => [
        'algo' => 'RS256',
        'key_size' => 2048,
        'path' => storage_path('app/rsa'),
        'private_filename' => 'access_token_id_rsa',
        'public_filename' => 'access_token_id_rsa.pub'
    ]
];
