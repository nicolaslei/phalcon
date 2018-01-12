<?php

namespace Lianni\Bootstrap;

use Lianni\Provider;
use Phalcon\Mvc\Application;

class Mvc extends AbstractBootstrap
{
    private $providers = [
        Provider\Config\ServiceProvider::class,
        Provider\Logger\ServiceProvider::class,
        Provider\FileSystem\ServiceProvider::class,
        Provider\View\ServiceProvider::class,
        Provider\Dispatcher\ServiceProvider::class,
        Provider\UrlResolver\ServiceProvider::class,
        Provider\Database\ServiceProvider::class,
        Provider\Annotations\ServiceProvider::class,
        Provider\ModelsManager\ServiceProvider::class,

    ];

    protected $mode = 'normal';

    /**
     * Initializes the application
     */
    protected function initApplication()
    {
        $this->app  = new Application($this->di);
    }

    protected function initializeServiceProviders()
    {
        foreach ($this->providers as $provider) {
            $this->initializeServiceProvider(new $provider($this->di));
        }
    }
}