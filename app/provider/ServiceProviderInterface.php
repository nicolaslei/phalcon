<?php

namespace Lianni\Provider;

use Phalcon\Di\InjectionAwareInterface;

interface ServiceProviderInterface extends InjectionAwareInterface
{
    public function register($application);
}