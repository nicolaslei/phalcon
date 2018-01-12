<?php

namespace Lianni\Bootstrap;

use Phalcon\Cli\Console;

class Cli extends AbstractBootstrap
{

    /**
     * Initializes the application
     */
    protected function initApplication()
    {
        $this->app = new Console($this->di);
    }

    protected function initializeServiceProviders()
    {
        // TODO: Implement initializeServiceProviders() method.
    }
}