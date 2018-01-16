<?php

namespace Lianni\Provider\ErrorHandler;

use Lianni\Exception\Handler\ErrorPageHandler;
use Lianni\Exception\Handler\LoggerHandler;
use Lianni\Provider\AbstractServiceProvider;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ServiceProvider extends AbstractServiceProvider
{
    public function register($application)
    {
        $run  = new Run();
        $mode = container('bootstrap')->getMode();

        switch ($mode) {
            case 'normal':
                if (env('APP_DEBUG', false)) {
                    $handler = new PrettyPageHandler();
                    $handler->setPageTitle('出错了');

                    $run->pushHandler($handler);
                } else {
                    $run->pushHandler(new ErrorPageHandler);
                }
                break;
            default:
                new \InvalidArgumentException(
                    sprintf(
                        '无效的应用程序模式[%s]，期望是 "normal" 或 "cli" 或者 "api".',
                        is_scalar($mode) ? $mode : var_export($mode, true)
                    )
                );
        }

        $run->pushHandler(new LoggerHandler);

        $run->register();
    }
}