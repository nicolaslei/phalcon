<?php

namespace Lianni\Provider\ModelsCache;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Cache\Frontend\Data;

class ServiceProvider extends AbstractServiceProvider
{
    public function register($application)
    {
        $this->di->setShared(
            'modelsCache',
            function () {
                $config = container('config')->cache;

                $driver  = $config->drivers->{$config->default};
                $adapter = '\Phalcon\Cache\Backend\\' . $driver->adapter;
                $default = [
                    'statsKey' => 'SMC:'.substr(md5($config->prefix), 0, 16).'_',
                    'prefix'   => 'PMC_'.$config->prefix,
                ];

                return new $adapter(
                    new Data(['lifetime' => $config->lifetime]),
                    array_merge($driver->toArray(), $default)
                );
            }
        );
    }
}