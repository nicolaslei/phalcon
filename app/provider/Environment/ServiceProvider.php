<?php

namespace Lianni\Provider\Environment;

use Lianni\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'environment',
            function ($value = null) {
                $environment = container('bootstrap')->getEnvironment();

                if (func_num_args() > 0) {
                    $patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

                    foreach ($patterns as $pattern) {
                        if ($pattern === $environment) {
                            return true;
                        }
                    }

                    return false;
                }

                return $environment;
            }
        );
    }
}