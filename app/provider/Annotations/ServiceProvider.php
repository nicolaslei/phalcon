<?php

namespace Lianni\Provider\Annotations;

//use Lianni\Annotations\Factory;
use Phalcon\Annotations\Factory;
use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'annotations',
            function () {
                $config      = container('config')->annotations;
                $annotations = Factory::load($config);

                return $annotations;
            }
        );
    }
}