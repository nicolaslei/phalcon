<?php

namespace Lianni\Provider\Database;

use Lianni\Listener\Database as DatabaseListener;
use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'db',
            function () {
                $config  = container('config')->database;
                $em      = container('eventsManager');
                $adapter = '\Phalcon\Db\Adapter\Pdo\\' . $config->adapter;

                /** @var \Phalcon\Db\Adapter\Pdo $connection */
                $connection = new $adapter($config->toArray());

                $em->attach('db', new DatabaseListener());
                $connection->setEventsManager($em);

                return $connection;
            }
        );
    }
}