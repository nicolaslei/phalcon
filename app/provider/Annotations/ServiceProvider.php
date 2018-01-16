<?php

namespace Lianni\Provider\Annotations;

use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register($application)
    {
        $this->di->setShared(
            'annotations',
            function () {
                $config  = container('config')->annotations;
                $driver  = $config->drivers->{$config->default};
                $adapter = '\Phalcon\Annotations\Adapter\\' . $driver->adapter;

                $default = [
                    'lifetime' => $config->lifetime,
                    'prefix'   => $config->prefix,
                ];

                return new $adapter(array_merge($driver->toArray(), $default));
            }
        );
    }
}