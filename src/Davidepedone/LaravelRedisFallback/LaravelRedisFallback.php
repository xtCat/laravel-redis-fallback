<?php

namespace Davidepedone\LaravelRedisFallback;

use Exception;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\RedisStore;

/**
 * @author Davide Pedone <davide.pedone@gmail.com>
 **/
class LaravelRedisFallback extends CacheManager
{

    /**
     * Create an instance of the Redis cache driver.
     *
     * @param  array $config
     *
     * @return \Illuminate\Cache\RedisStore
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
            return parent::createFileDriver();
        }
    }
}
