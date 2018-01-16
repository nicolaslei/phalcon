<?php

namespace Lianni\Provider\Dispatcher;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class ServiceProvider extends AbstractServiceProvider
{
    public function register($application)
    {
        $this->di->setShared(
            'dispatcher',
            function () {
                $mode = container('bootstrap')->getMode();

                switch ($mode) {
                    case 'normal':
                        $dispatcher = new MvcDispatcher();
                        $dispatcher->setDefaultNamespace('Lianni\Controller');

                        container('eventsManager')->attach('dispatch', new Listener(container()));
                        break;
                    default:
                        throw new \InvalidArgumentException(
                            sprintf(
                                '无效的应用程序模式[%s]，期望是 "normal" 或 "cli" 或者 "api".',
                                is_scalar($mode) ? $mode : var_export($mode, true)
                            )
                        );
                }

                $dispatcher->setDI(container());
                $dispatcher->setEventsManager(container('eventsManager'));

                return $dispatcher;
            }
        );
    }
}