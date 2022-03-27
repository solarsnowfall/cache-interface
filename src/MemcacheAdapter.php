<?php

namespace Solarsnowfall\Cache;

class MemcacheAdapter extends CacheAbstract implements CacheInterface
{
    /**
     * @var \Memcache
     */
    protected $store;

    /**
     * @param string $key
     * @param mixed $var
     * @param int $expire
     * @return bool
     */
    public function add(string $key, $var, int $expire = 0): bool
    {
        if ($this->store->add($key, $var, MEMCACHE_COMPRESSED, $expire))
        {
            $this->addListKey($key);

            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @param mixed $var
     * @param int $expire
     * @return bool
     */
    public function set(string $key, $var, int $expire = 0): bool
    {
        if ($this->store->set($key, $var, MEMCACHE_COMPRESSED, $expire))
        {
            $this->addListKey($key);

            return true;
        }

        return false;
    }
}