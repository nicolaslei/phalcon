<?php

namespace Lianni\Provider\Config;

use Phalcon\Config;
use League\Flysystem\Filesystem;

/**
 * Lianni\Provider\Config\Factory
 *
 * @package Lianni\Provider\Config
 */
class Factory
{
    /**
     * Create configuration object.
     *
     * @param  array  $providers
     * @return Config
     */
    public static function create(array $providers = [])
    {
        return self::load($providers);
    }

    /**
     * Load all configuration.
     *
     * @param  array $providers
     * @return Config
     */
    protected static function load(array $providers)
    {
        $config = new Config();
        $merge  = self::merge();

        /** @var Filesystem $filesystem */
        $filesystem = container('filesystem', [cache_path('config')]);

        if ($filesystem->has('cached.php') && !environment('development') && !env('APP_MAINTAIN', false)) {
            $merge($config, cache_path('config/cached.php'));

            return $config;
        }

        foreach ($providers as $provider) {
            $merge($config, config_path("$provider.php"), $provider == 'config' ? null : $provider);
        }

        if (!environment('development') && (env('APP_MAINTAIN', false) || !$filesystem->has('cached.php'))) {
            self::dump($filesystem, 'cached.php', $config->toArray());
        }

        return $config;
    }

    protected static function merge()
    {
        return function (Config &$config, $path, $node = null) {
            /** @noinspection PhpIncludeInspection */
            $toMerge = include($path);

            if (is_array($toMerge)) {
                $toMerge = new Config($toMerge);
            }

            if ($toMerge instanceof Config) {
                if (!$node) {
                    return $config->merge($toMerge);
                }

                if (!$config->offsetExists($node) || !$config->{$node} instanceof Config) {
                    $config->offsetSet($node, new Config());
                }

                return $config->get($node)->merge($toMerge);
            }

            return null;
        };
    }

    protected static function dump(Filesystem $filesystem, $path, array $data)
    {
        $contents = '<?php' . PHP_EOL;
        $contents .= 'return ' . var_export($data, true) . ';' . PHP_EOL;

        $filesystem->put($path, $contents, $data);
    }
}
