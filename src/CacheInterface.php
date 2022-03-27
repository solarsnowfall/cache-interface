<?php

namespace Solarsnowfall\Cache;

interface CacheInterface
{
    /**
     * @param string $key
     * @param mixed $var
     * @param int $expire
     * @return bool
     */
    public function add(string $key, $var, int $expire = 0): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool;

    /**
     * @return bool
     */
    public function flush(): bool;

    /**
     * @param string $key
     * @param callable|null $callback
     * @param int $expire
     * @return mixed
     */
    public function get(string $key, callable $callback = null, int $expire = 0);

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function listKeys(int $limit = 0, int $offset = 0): array;

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function listValues(int $limit = 0, int $offset = 0): array;

    /**
     * @param string $key
     * @param mixed $var
     * @param int $expire
     * @return bool
     */
    public function set(string $key, $var, int $expire = 0): bool;
}