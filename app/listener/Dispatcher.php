<?php

namespace Lianni\Listener;

use Phalcon\Dispatcher as PhaDispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher\Exception;
use Lianni\Exception\LianniException;

class Dispatcher
{
    /**
     * 调度异常处理.
     *
     * @param  Event         $event
     * @param  PhaDispatcher $dispatcher
     * @param  \Exception    $exception
     * @return bool
     *
     * @throws \Exception|\Throwable
     */
    public function beforeException(Event $event, PhaDispatcher $dispatcher, $exception)
    {
        if ($exception instanceof Exception) {
            switch ($exception->getCode()) {
                case PhaDispatcher::EXCEPTION_CYCLIC_ROUTING:
                    $code = 400;
                    $dispatcher->forward([
                        'controller' => 'error',
                        'action'     => 'route400',
                    ]);

                    break;
                default:
                    $code = 404;
                    $dispatcher->forward([
                        'controller' => 'error',
                        'action'     => 'route404',
                    ]);
            }

            container('logger')->error("Dispatching [$code]: " . $exception->getMessage());

            return false;
        }

        if ($exception instanceof LianniException) {
            switch ($exception->getCode()) {
                case 404:
                    $code = 404;
                    $dispatcher->forward([
                        'controller' => 'error',
                        'action'     => 'route404',
                    ]);

                    break;
                default:
                    $code = 404;
                    $dispatcher->forward([
                        'controller' => 'error',
                        'action'     => 'route404',
                    ]);
            }

            container('logger')->error("Dispatching [$code]: " . $exception->getMessage());

            return false;
        }

        if ($exception instanceof \Exception || $exception instanceof \Throwable) {
            container('logger')->error("Dispatching [{$exception->getCode()}]: " . $exception->getMessage());

            if (!environment('production')) {
                throw $exception;
            }
        }

        $dispatcher->forward([
            'controller' => 'error',
            'action'     => 'route500',
        ]);

        return $event->isStopped();
    }
}