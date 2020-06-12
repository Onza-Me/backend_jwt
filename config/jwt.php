<?php

return [
    'access_token_expires_in' => 1800,
    'refresh_token_expires_in' => 604800,
    'rsa' => [
        'algo' => 'RS256',
        'key_size' => 2048,
        'path' => storage_path('app/rsa'),
        'private_filename' => 'access_token_id_rsa',
        'public_filename' => 'access_token_id_rsa.pub'
    ]
];
