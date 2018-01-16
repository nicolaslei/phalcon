<?php

namespace Lianni\Provider\View;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Mvc\View;

class ServiceProvider extends AbstractServiceProvider
{
    public function register($application)
    {
        $this->di->setShared(
            'view',
            function () {
                $config = container('config')->application;
                $mode   = container('bootstrap')->getMode();

                switch ($mode) {
                    case 'normal';
                        $view = new View();
                        break;
                    default:
                        throw new \InvalidArgumentException(
                            sprintf(
                                '无效的应用程序模式[%s]，期望是 "normal" 或 "cli" 或者 "api".',
                                is_scalar($mode) ? $mode : var_export($mode, true)
                            )
                        );
                }

                $view->registerEngines([
                    '.php' => View\Engine\Php::class
                ]);

                $view->setViewsDir($config->viewsDir);

                $eventsManager = container('eventsManager');
                $eventsManager->attach('view', new Listener());

                $view->setEventsManager($eventsManager);

                return $view;
            }
        );
    }
}