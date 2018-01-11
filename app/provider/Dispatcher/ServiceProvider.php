<?php

namespace Lianni\Provider\Dispatcher;


use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'dispatcher',
            function () {
                $dispatcher = new MvcDispatcher();
                $dispatcher->setDefaultNamespace('Lianni\Controller');

                $dispatcher->setDI(container());

                return $dispatcher;
            }
        );
    }
}