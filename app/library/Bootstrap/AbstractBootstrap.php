<?php

namespace Lianni\Bootstrap;

use Lianni\Provider;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;

abstract class AbstractBootstrap
{
    protected $di;

    /**
     * @var \Phalcon\Application
     */
    protected $app;

    /**
     * The application mode.
     * @var string
     */
    protected $mode;

    protected $environment;

    public function __construct()
    {
        if (!$this->mode) {
            throw new \LogicException(
                sprintf('"%s" 必须设置应用的模式[mode].', get_class($this))
            );
        }

        $this->di = new FactoryDefault();
        Di::setDefault($this->di);
        $this->di->setShared('bootstrap', $this);
    }
    /**
     * Initializes the application
     */
    abstract protected function initApplication();

    abstract protected function initializeServiceProviders();

    final public function run()
    {
        /**
         *
         * 先注册框架的事件管理
         */
        $this->initializeServiceProvider(new Provider\EventsManager\ServiceProvider());
        // 设置环境
        $this->setupEnvironment();
        // 注册错误处理程序
        $this->initializeServiceProvider(new Provider\ErrorHandler\ServiceProvider($this->di));

        $this->initApplication();

        /**
         * 注册其他服务
         * 由应用的模式决定注册什么服务
         */
        $this->initializeServiceProviders();

        $this->app->setEventsManager(container('eventsManager'));

        $this->di->setShared('app', $this->app);
        $this->app->setDI($this->di);

        return $this->runApplication();
    }

    public function getMode()
    {
        return $this->mode;
    }

    /**
     * 获取应用当前环境: production, staging, development, testing, etc.
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    protected function runApplication()
    {
        return $this->app->handle()->getContent();
    }
    protected function setupEnvironment()
    {
        $this->environment = env('APP_ENV', 'development');
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', $this->environment);

        $this->initializeServiceProvider(new Provider\Environment\ServiceProvider($this->di));
    }

    /**
     * 注册服务
     *
     * @param Provider\ServiceProviderInterface $serviceProvider
     */
    protected function initializeServiceProvider(Provider\ServiceProviderInterface $serviceProvider)
    {
        $serviceProvider->register();
    }
}