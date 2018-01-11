<?php

namespace Lianni\Provider;

use Phalcon\Mvc\User\Component;

abstract class AbstractServiceProvider extends Component implements ServiceProviderInterface
{
    final public function __construct()
    {
        $this->onConstruct();
    }

    public function onConstruct()
    {
    }
}