<?php

return [
    'routes' => [
        'user_root' => 'user',
    ],
    'login' => [
        // emphasize through login links that they will login through battlenet, in case we allow logins from other places
        'default_socialite_provider' => 'battlenet',
    ],
    'battlenet' => [
        'regions' => [
            'US', 'EU', 'APAC', 'CN',
        ],
    ],
];
