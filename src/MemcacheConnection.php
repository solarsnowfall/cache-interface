<?php

namespace Solarsnowfall;

class MemcacheConnection extends ClassSingleton
{
    const CLASS_NAME = 'Solarsnowfall\\MemcacheAdapter';

    /**
     * @return MemcacheAdapter
     * @throws \Exception
     */
    public static function get(): MemcacheAdapter
    {
        return parent::get();
    }

    /**
     * @return array[]
     */
    public static function instanceArgs(): array
    {
        return [
            [
                'host' => 'localhost',
                'port' => 11211
            ]
        ];
    }

    /**
     * @return MemcacheAdapter
     */
    public static function newInstance(): MemcacheAdapter
    {
        $store = new \Memcache();

        $servers = static::instanceArgs();

        foreach ($servers as $server)
            $store->addServer($server['host'], $server['port']);

        return new MemcacheAdapter($store);
    }
}