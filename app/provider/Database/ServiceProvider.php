<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 22:36
 */

namespace Lianni\Provider\Database;


use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Db\Adapter\Pdo\Factory;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'db',
            function () {
                $config = container('config')->database;
                $em     = container('eventsManager');

                /** @var \Phalcon\Db\Adapter\Pdo $connection */
                $connection = Factory::load($config);

                $em->attach('db', new Database());

                $connection->setEventsManager($em);

                return $connection;
            }
        );
    }

}