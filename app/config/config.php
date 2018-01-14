<?php
return [
    'application' => [
        'viewsDir' => app_path('views') . DIRECTORY_SEPARATOR,
        'baseUri'  => env('APP_BASE_URI'),
    ],
    'error'       => [
        'logger'     => app_path('logs/error.log'),
        'formatter'  => [
            'format' => env('LOGGER_FORMAT', '[%date%][%type%] %message%'),
            'date'   => 'Y-m-d H:i:s',
        ],
        'controller' => 'error',
        'action'     => 'route500',
    ],
];