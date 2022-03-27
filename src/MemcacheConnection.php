<?php

namespace Solarsnowfall\Cache;

use Solarsnowfall\Reflection\SingletonFactory;

class MemcacheConnection extends SingletonFactory
{
    const CLASS_NAME = 'Solarsnowfall\\Cache\\MemcacheAdapter';

    const DEFAULT_PARAMS = [['host' => 'localhost', 'port' => 11211]];

    /**
     * Redeclaration for type specificity.
     *
     * @param array $params
     * @return MemcacheAdapter|null
     * @throws \Exception
     */
    public static function get(array $params = self::DEFAULT_PARAMS): ?MemcacheAdapter
    {
        return parent::get($params);
    }

    /**
     * @param array $params
     * @return MemcacheAdapter|null
     */
    public static function newInstance(array $params = self::DEFAULT_PARAMS): ?MemcacheAdapter
    {
        $store = new \Memcache();

        $adapter = new MemcacheAdapter($store);

        foreach ($params as $server)
            $adapter->addServer($server['host'], $server['port']);

        return $adapter;
    }
}