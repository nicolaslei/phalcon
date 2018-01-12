<?php
require dirname(__DIR__) . '/vendor/autoload.php';

try {
    (new \Dotenv\Dotenv(dirname(app_path())))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {

}