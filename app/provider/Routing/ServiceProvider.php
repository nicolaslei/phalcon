<?php

namespace Lianni\Provider\Routing;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Mvc\Router;

class ServiceProvider extends AbstractServiceProvider
{
    const CACHE_NAME = 'app_router';

    public function register()
    {
        $this->di->setShared(
            'router',
            function () {
                $mode = container('bootstrap')->getMode();

                switch ($mode) {
                    case 'normal':
                        $dataCache = container('dataCache');
                        $maintain  = container('maintain');

                        /** @var Router $router */
                        $router = $dataCache->get(self::CACHE_NAME);

                        if (environment('development') || $maintain !== false || $router === null) {
                            // 非开发环境、缓存为空或者是维护状态才保存缓存
                            $saveToCache = (($router === null || $maintain !== false) && environment('production', 'testing'));

                            $router = new Router\Annotations(false);
                            $files  = scandir(app_path('controller'));
                            foreach ($files as $file) {
                                if ($file == "." || $file == ".." || strpos($file, 'Controller.php') === false || strpos($file, '.swp') !== false) {
                                    continue;
                                }

                                $handler = str_replace('Controller.php', '', $file);
                                $router->addResource($handler);
                            }

                            if ($saveToCache) {
                                $dataCache->save(self::CACHE_NAME, $router, 2592000); // 30 days cache
                            }
                        }

                        if (!isset($_GET['_url'])) {
                            $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
                        }

                        $router->setDefaultNamespace('Lianni\Controller');
                        $router->removeExtraSlashes(true);
                        $router->notFound([
                            'controller' => 'error',
                            'action'     => 'route404',
                        ]);

                        $router->setEventsManager(container('eventsManager'));

                        break;
                    case 'cli':
                        /** @noinspection PhpIncludeInspection */
                        $router = require config_path('cli-routes.php');

                        break;
                    case 'api':
                        throw new \InvalidArgumentException(
                            'Not implemented yet.'
                        );
                    default:
                        throw new \InvalidArgumentException(
                            sprintf(
                                '无效的应用程序模式[%s]，期望是 "normal" 或 "cli" 或者 "api".',
                                is_scalar($mode) ? $mode : var_export($mode, true)
                            )
                        );
                }

                $router->setDI(container());

                return $router;
            }
        );
    }
}