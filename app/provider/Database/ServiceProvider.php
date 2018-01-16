<?php

namespace Lianni\Provider\Database;

use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register($application)
    {
        $this->di->setShared(
            'db',
            function () {
                $config  = container('config')->database;
                $em      = container('eventsManager');
                $adapter = '\Phalcon\Db\Adapter\Pdo\\' . $config->adapter;

                /** @var \Phalcon\Db\Adapter\Pdo $connection */
                $connection = new $adapter($config->toArray());

                $em->attach('db', new Listener());
                $connection->setEventsManager($em);

                return $connection;
            }
        );
    }
}