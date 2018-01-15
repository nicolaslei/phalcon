<?php
return [
    'site'        => [
        'name' => env('APP_NAME'),
        'url'  => env('APP_URL'),
    ],
    'application' => [
        'viewsDir'      => app_path('views') . DIRECTORY_SEPARATOR,
        'baseUri'       => env('APP_BASE_URI'),
        'hashingFactor' => 12,
        'debug'         => env('APP_DEBUG', false),
    ],
    'error'       => [
        'controller' => 'error',
        'action'     => 'route500',
    ],
];