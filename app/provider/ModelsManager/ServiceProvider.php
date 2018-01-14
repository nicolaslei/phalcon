<?php

namespace Lianni\Provider\ModelsManager;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Mvc\Model\Manager;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'modelsManager',
            function () {
                $config        = container('config')->database;
                $eventsManager = container('eventsManager');
                $modelsManager = new Manager();

                //$eventsManager->attach('modelsManager', new Listener());

                $modelsManager->setModelPrefix($config->sourceprefix);
                $modelsManager->setEventsManager($eventsManager);

                return $modelsManager;
            }
        );
    }
}