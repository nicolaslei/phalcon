<?php

namespace Lianni\Provider\Session;

use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'session',
            function () {
                $config = container('config')->session;

                $driver   = $config->drivers->{$config->default};
                $adapter  = '\Phalcon\Session\Adapter\\' . $driver->adapter;
                $defaults = [
                    'prefix'   => $config->prefix,
                    'uniqueId' => $config->uniqueId,
                    'lifetime' => $config->lifetime,
                ];

                /** @var \Phalcon\Session\AdapterInterface $session */
                $session = new $adapter(array_merge($driver->toArray(), $defaults));
                $session->start();

                return $session;
            }
        );
    }
}