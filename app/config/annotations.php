<?php

return [
    'adapter'  => env('ANNOTATIONS_ADAPTER', 'memory'),
    'prefix'   => env('ANNOTATIONS_PREFIX', 'lianni_annotations_'),
    'lifetime' => env('ANNOTATIONS_LIFETIME', 86400),
];