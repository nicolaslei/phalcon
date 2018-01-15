<?php

namespace Lianni\Bootstrap;

use Phalcon\Cli\Console;

class Cli extends AbstractBootstrap
{

    /**
     * Initializes the application
     */
    public function initApplication()
    {
        $this->app = new Console($this->di);
    }

    public function initializeServiceProviders()
    {
        // TODO: Implement initializeServiceProviders() method.
    }
}