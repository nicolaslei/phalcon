<?php

namespace Lianni\Listener;

use Phalcon\Events\Event;
use Phalcon\Mvc\View\Exception;
use Phalcon\Mvc\ViewBaseInterface;

class View
{
    public function notFoundView(Event $event, ViewBaseInterface $view, $viewEnginePath)
    {
        if ($viewEnginePath && !is_array($viewEnginePath)) {
            $viewEnginePath = [$viewEnginePath];
        }

        $message = sprintf(
            '找不到视图文件：[%s]',
            ($viewEnginePath ? join(', ', $viewEnginePath) : gettype($viewEnginePath))
        );
        container()->get('logger')->error($message);

        if ($event->isCancelable()) {
            //$event->stop();
        }

        throw new Exception($message);
    }
}