<?php

namespace Lianni\Provider\FileSystem;


use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'filesystem',
            function ($root = null) {
                if ($root === null) {
                    $root = dirname(app_path());
                }

                return new Filesystem(new Local($root));
            }
        );
    }
}