<?php

namespace Solarsnowfall\Cache;

use Solarsnowfall\Reflection\SingletonFactory;

class MemcacheConnection extends SingletonFactory
{
    const CLASS_NAME = MemcacheAdapter::class;

    /**
     * @return array[]
     */
    public static function defaultInstanceParams(): array
    {
        return [['host' => 'localhost', 'port' => 11211]];
    }

    /**
     * Redeclaration for type specificity...
     *
     * @param array|null $params
     * @return MemcacheAdapter|null
     * @throws \Exception
     */
    public static function get(array $params = null): ?MemcacheAdapter
    {
        if ($params === null)
            $params = static::defaultInstanceParams();

        return parent::get($params);
    }

    /**
     * @param array $params
     * @return MemcacheAdapter|null
     */
    public static function newInstance(array $params): ?MemcacheAdapter
    {
        $store = new \Memcache();

        $adapter = new MemcacheAdapter($store);

        foreach ($params as $server)
            $adapter->addServer($server['host'], $server['port']);

        return $adapter;
    }
}