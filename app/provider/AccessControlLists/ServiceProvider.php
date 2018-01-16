<?php

namespace Lianni\Provider\AccessControlLists;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Config;

class ServiceProvider extends AbstractServiceProvider
{
    public function register($application)
    {
        $this->di->setShared(
            'acl',
            function () {
                $config  = container('config')->acldriver;

                $driver  = $config->drivers->{$config->default};
                $adapter = '\Phalcon\Acl\Adapter\\' . $driver->adapter;

                switch ($config->default) {
                    case 'memory':
                        $factory = new $adapter();

                        // returns instance of \Phalcon\Acl\Adapter\Memory
                        $adapter = $factory->create(
                            new Config($config->alcFilePath)
                        );

                        break;
                    case 'database':
                        $adapter = new $adapter(
                            array_merge($config->schemas->toArray(), ['db' => container('db')])
                        );

                        break;
                    case 'redis':
                        $adapter = new $adapter(container('redis'));

                        break;
                    case 'mongo':
                        $adapter = new $adapter(
                            array_merge($config->schemas->toArray(), ['db' => container('mongo')])
                        );

                        break;
                    default:
                        new \InvalidArgumentException(
                            sprintf("找不到访问控制驱动 [%s]", $adapter)
                        );
                }

                return $adapter;
            }
        );
    }
}