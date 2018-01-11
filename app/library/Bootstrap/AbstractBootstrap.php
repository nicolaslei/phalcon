<?php

namespace Lianni\Bootstrap;

use Lianni\Provider;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;

abstract class AbstractBootstrap
{
    protected $di;

    protected $app;

    /**
     * The application mode.
     * @var string
     */
    protected $mode;

    protected $environment;

    public function __construct()
    {
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
         * These services should be registered first
         */
        $this->initializeServiceProvider(new Provider\EventsManager\ServiceProvider());
        $this->setupEnvironment();
        $this->initializeServiceProvider(new Provider\ErrorHandler\ServiceProvider($this->di));

        $this->initApplication();
        $this->initializeServiceProviders();

        return $this->runApplication();
    }

    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Gets current application environment: production, staging, development, testing, etc.
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
        $this->environment = env('SITE_ENV', 'development');
        defined('APPLICATION_ENV') || define('APPLICATION_ENV', $this->environment);

        $this->initializeServiceProvider(new Provider\Environment\ServiceProvider($this->di));
    }

    protected function initializeServiceProvider(Provider\ServiceProviderInterface $serviceProvider): void
    {
        $serviceProvider->register();
    }
}