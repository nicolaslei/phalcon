<?php

namespace Lianni\Exception\Handler;

use Whoops\Handler\Handler;

/**
 * Lianni\Exception\Handler\ErrorPageHandler
 *
 * @package Lianni\Error\Handler
 */
class ErrorPageHandler extends Handler
{
    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function handle()
    {
        $exception = $this->getException();

        if (!$exception instanceof \Exception && !$exception instanceof \Throwable) {
            return Handler::DONE;
        }

        if (!container()->has('view') || !container()->has('dispatcher') || !container()->has('response')) {
            return Handler::DONE;
        }

        switch ($exception->getCode()) {
            case E_WARNING:
            case E_NOTICE:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            case E_STRICT:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
            case E_ALL:
                return Handler::DONE;
        }

        $this->renderErrorPage();

        return Handler::QUIT;
    }

    /**
     * 渲染错误页面
     * @throws \Exception
     */
    private function renderErrorPage()
    {
        $config = container('config')->error;
        /** @var \Phalcon\Dispatcher $dispatcher */
        $dispatcher = container('dispatcher');
        /** @var \Phalcon\Mvc\View $view */
        $view     = container('view');
        $response = container('response');

        $dispatcher->setControllerName($config->controller);
        $dispatcher->setActionName($config->action);

        $view->start();
        $dispatcher->dispatch();
        $view->render($config->controller, $config->action, $dispatcher->getParams());
        $view->finish();

        $response->setContent($view->getContent())->send();
    }
}
