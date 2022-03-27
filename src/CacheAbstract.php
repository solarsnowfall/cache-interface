<?php

namespace Solarsnowfall\Cache;

class CacheAbstract
{
    /**
     * @var \Memcache
     */
    protected $store;

    /**
     * @var string
     */
    protected string $listKey;

    /**
     * @param $store
     */
    public function __construct($store)
    {
        $this->store = $store;

        $this->listKey = '__' . str_replace('\\', '__', get_called_class()) . '__';
    }

    /**
     * @param string $host
     * @param int $port
     * @return bool
     */
    public function addServer(string $host, int $port): bool
    {
        return $this->store->addServer($host, $port);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        if ($this->store->delete($key))
        {
            $this->deleteListKey($key);

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        return $this->store->flush();
    }

    /**
     * @param string $key
     * @param callable|null $callback
     * @param int $expire
     * @return array|false|mixed|string
     */
    public function get(string $key, callable $callback = null, int $expire = 0)
    {
        if ($key === $this->listKey)
            return false;

        $var = $this->store->get($key);

        if ($var !== false || $callback === null)
            return $var;

        $var = $callback();

        $this->set($key, $var, $expire);

        return $var;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function listKeys(int $limit = 0, int $offset = 0): array
    {
        $keys = $this->store->get($this->listKey) ?? [];

        return array_keys($keys);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function listValues(int $limit = 0, int $offset = 0): array
    {
        $keys = $this->store->get($this->listKey);

        if ($keys === false)
            return [];

        if ($limit || $offset)
            $keys = array_splice($keys, $offset, $limit);

        $values = [];

        foreach ($keys as $key)
        {
            $var = $this->get($key);

            if ($var !== false)
                $values[$key] = $var;
        }

        return $values;
    }

    /**
     * @param string $key
     * @return int
     */
    final protected function addListKey(string $key): int
    {
        $keys = $this->getListKeys();

        $keys[$key] = true;

        $this->store->set($this->listKey, $keys);

        return count($keys);
    }

    /**
     * @param string $key
     * @return int
     */
    final protected function deleteListKey(string $key): int
    {
        $keys = $this->getListKeys();

        if (empty($keys))
            return false;

        unset($keys[$key]);

        $this->store->set($this->listKey, $keys);

        return count($keys);
    }

    /**
     * @return array
     */
    private function getListKeys(): array
    {
        $keys = $this->store->get($this->listKey);

        if ($keys === false)
            return [];

        return $keys;
    }
}