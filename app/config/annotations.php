<?php

return [
    'default'  => env('ANNOTATIONS_DRIVER', 'memory'),
    'drivers'  => [
        'apc'    => [
            'adapter' => 'Apc',
        ],
        'xcache' => [
            'adapter' => 'Xcache',
        ],
        'file'   => [
            'adapter'        => 'Files',
            'annotationsDir' => cache_path('annotations') . DIRECTORY_SEPARATOR
        ],
        'memory' => [
            'adapter' => 'Memory',
        ],
    ],
    'prefix'   => env('ANNOTATIONS_PREFIX', 'forum_annotations_'),
    'lifetime' => env('ANNOTATIONS_LIFETIME', 86400),
];
