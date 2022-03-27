<?php

namespace Solarsnowfall\Cache;

use Solarsnowfall\Reflection\SingletonFactory;

class MemcacheConnection extends SingletonFactory
{
    const CLASS_NAME = 'Solarsnowfall\\Cache\\MemcacheAdapter';

    const DEFAULT_PARAMS = [['host' => 'localhost', 'port' => 11211]];

    /**
     * @return MemcacheAdapter
     * @throws \Exception
     */
    public static function get(array $params = self::DEFAULT_PARAMS): ?object
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