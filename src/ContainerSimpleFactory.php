<?php

namespace EdipoReboucas\KohanaPhpDi;

use DI\Cache\ArrayCache;
use \DI\ContainerBuilder;
use EdipoReboucas\KohanaPhpDi\Cache\Wrapper;

class ContainerSimpleFactory
{
    public static function factory()
    {
        $builder = new ContainerBuilder();

        $config = self::config('container/config');

        $builder->useAnnotations($config['useAnnotations']);
        $builder->useAutowiring($config['useAutowiring']);
        $builder->ignorePhpDocErrors($config['ignorePhpDocErrors']);
        $builder->writeProxiesToFile($config['writeProxiesToFile'], $config['proxyDirectory']);

        $builder->addDefinitions(self::config('container/definitions'));
        $builder->addDefinitions(self::config('container/parameters'));

        if ($config['cache']['driver']) {
            $cache = \Cache::instance($config['cache']['driver']);
            $cacheWrapper = new Wrapper($cache);
            $cacheWrapper->setNamespace($config['cache']['namespace']);
            $builder->setDefinitionCache($cacheWrapper);
        }

        return $builder->build();
    }

    /**
     * @return array
     */
    private static function config($group)
    {
        return \Kohana::$config->load($group)->as_array();
    }

    /**
     * @return \DI\Container
     */
    public static function getInstance()
    {
        static $container;

        if ($container) {
            return $container;
        } else {
            $container = static::factory();
            return $container;
        }
    }
}