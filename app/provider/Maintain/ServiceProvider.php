<?php

namespace Lianni\Provider\Maintain;

use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'maintain',
            function () {
                #todo
                return false;
            }
        );
    }
}