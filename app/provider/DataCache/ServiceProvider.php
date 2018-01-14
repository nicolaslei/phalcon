<?php

namespace Lianni\Provider\DataCache;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Cache\Frontend\Data;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'dataCache',
            function () {
                $config = container('config')->cache;

                $driver  = $config->drivers->{$config->default};
                $adapter = '\Phalcon\Cache\Backend\\' . $driver->adapter;
                $default = [
                    'statsKey' => 'SDC:'.substr(md5($config->prefix), 0, 16).'_',
                    'prefix'   => 'PDC_'.$config->prefix,
                ];

                return new $adapter(
                    new Data(['lifetime' => $config->lifetime]),
                    array_merge($driver->toArray(), $default)
                );
            }
        );
    }
}