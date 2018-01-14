<?php

namespace Lianni\Provider\Security;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Security;

class ServiceProvider extends AbstractServiceProvider
{
    const DEFAULT_WORK_FACTOR = 12;

    public function register()
    {
        $this->di->setShared(
            'security',
            function () {
                $config     = container('config');
                $security   = new Security();
                $workFactor = self::DEFAULT_WORK_FACTOR;

                if (!empty($config->application->hashingFactor)) {
                    $workFactor = (int)$config->application->hashingFactor;
                }

                $security->setWorkFactor($workFactor);

                return $security;
            }
        );
    }
}