<?php

namespace Lianni\Bootstrap;

use Lianni\Provider;
use Phalcon\Mvc\Micro;

class Api extends AbstractBootstrap
{
    private $providers = [
        Provider\Config\ServiceProvider::class,
        Provider\Logger\ServiceProvider::class,
        Provider\FileSystem\ServiceProvider::class,
        Provider\Dispatcher\ServiceProvider::class,
        Provider\UrlResolver\ServiceProvider::class,
        Provider\Session\ServiceProvider::class,
        Provider\Database\ServiceProvider::class,
        Provider\Annotations\ServiceProvider::class,
        Provider\ModelsManager\ServiceProvider::class,
        Provider\ModelsMetadata\ServiceProvider::class,
        Provider\Security\ServiceProvider::class,
        Provider\Routing\ServiceProvider::class,
        Provider\DataCache\ServiceProvider::class,
    ];

    protected $mode = 'api';

    /**
     * Initializes the application
     */
    public function initApplication()
    {
        $this->app  = new Micro($this->di);
    }

    public function initializeServiceProviders()
    {
        foreach ($this->providers as $provider) {
            $this->initializeServiceProvider(new $provider($this->di));
        }
    }

    public function runApplication()
    {
        return $this->app->handle();
    }
}