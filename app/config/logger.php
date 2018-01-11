<?php
return [
    'path' => storage_path('logs'),
    'format' => env('LOGGER_FORMAT', '[%date%][%type%] %message%'),
    'date' => 'Y-m-d H:i:s',
    'level' => env('LOGGER_LEVEL', 'info'),
    'filename' => env('LOGGER_DEFAULT_FILENAME', 'application'),
];