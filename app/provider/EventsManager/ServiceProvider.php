<?php

namespace Lianni\Provider\EventsManager;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Events\Manager;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'eventsManager',
            function () {
                $em = new Manager();
                $em->enablePriorities(true);

                return $em;
            }
        );
    }
}