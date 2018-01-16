<?php

namespace Lianni\Provider\Config;

use Lianni\Provider\AbstractServiceProvider;

/**
 * Lianni\Provider\Config\ServiceProvider
 *
 * @package Lianni\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Config files.
     * @var array
     */
    protected $configs = [];

    public function onConstruct()
    {
        $configDirectory = config_path();
        /**
         * 读取配置文件
         */
        $configFiles = scandir($configDirectory);

        foreach ($configFiles as $file) {
            if ($file == '.' || $file == '..' || stripos($file, '.swp')) {
                continue;
            }

            $file            = strtolower($file);
            $this->configs[] = basename($file, '.php');
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register($application)
    {
        $configs = $this->configs;

        $this->di->setShared(
            'config',
            function () use ($configs) {
                return Factory::create($configs);
            }
        );
    }
}
