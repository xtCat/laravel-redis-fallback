<?php

namespace guillermobt\LaravelRedisFallback;

use Exception;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\RedisStore;
use Illuminate\Support\Arr;

/**
 * Redis fallback
 *
 * @package Xtcat
 * @subpackage LaravelRedisFallback
 *
 * @author Davide Pedone <davide.pedone@gmail.com>
 * @author Peter Otto <peterotto87@gmail.com>
 */
class LaravelRedisFallback extends CacheManager
{

    /**
     * Create an instance of the Redis cache driver.
     *
     * @param  array $config
     *
     * @return \Illuminate\Cache\RedisStore|\Illuminate\Cache\FileStore
     */
    protected function createRedisDriver(array $config)
    {
        $redis = $this->app['redis'];

        $connection = Arr::get($config, 'connection', 'default') ?: 'default';

        $store = new RedisStore($redis, $this->getPrefix($config), $connection);

        try {
            $store->getRedis()->ping();

            return $this->repository($store);
        } catch (Exception $e) {
            event('redis.unavailable', null);

            return parent::createFileDriver(\Config::get('cache.stores.file'));
        }
    }
}
