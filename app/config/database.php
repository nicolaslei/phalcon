<?php

return [
    'adapter'      => env('DB_ADAPTER', 'mysql'),
    'host'         => env('DB_HOST', '127.0.0.1'),
    'dbname'       => env('DB_DATABASE', 'lnlife'),
    'port'         => env('DB_PORT', 3306),
    'username'     => env('DB_USERNAME', 'lianni'),
    'password'     => env('DB_PASSWORD', '123456'),
    'sourceprefix' => env('DB_SOURCE_PREFIX', 'lnsm_'),
    'charset'      => env('DB_CHARSET', 'utf8mb4'),
];