<?php

namespace Lianni\Provider\ModelsMetadata;

use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'modelsMetadata',
            function () {
                $config = container('config')->metadata;

                $driver   = $config->drivers->{$config->default};
                $adapter  = '\Phalcon\Mvc\Model\Metadata\\' . $driver->adapter;
                $defaults = [
                    'prefix'   => $config->prefix,
                    'lifetime' => $config->lifetime,
                ];

                return new $adapter(
                    array_merge($driver->toArray(), $defaults)
                );
            }
        );
    }
}