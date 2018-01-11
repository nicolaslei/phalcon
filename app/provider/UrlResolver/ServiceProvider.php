<?php

namespace Lianni\Provider\UrlResolver;

use Lianni\Provider\AbstractServiceProvider;
use Phalcon\Mvc\Url;

class ServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->di->setShared(
            'url',
            function () {
                $config = container()->application;
                $url = new Url();

                if (!empty($config->baseUri)) {
                    $url->setBaseUri($config->baseUri);
                } else {
                    $url->setBaseUri('/');
                }

                return $url;
            }
        );
    }
}