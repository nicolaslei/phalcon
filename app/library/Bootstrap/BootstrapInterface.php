<?php

namespace Lianni\Bootstrap;

interface BootstrapInterface
{
    /**
     * Initializes the application
     */
    public function initApplication();

    public function initializeServiceProviders();

    public function runApplication();
}