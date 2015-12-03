<?php

namespace xtcat\LaravelRedisFallback;

use Illuminate\Cache\CacheServiceProvider;

/**
 * Redis fallback service provider
 *
 * @package xtcat
 * @subpackage LaravelRedisFallback
 *
 * @author Davide Pedone <davide.pedone@gmail.com>
 * @author Peter Otto <peterotto87@gmail.com>
 */
class LaravelRedisFallbackServiceProvider extends CacheServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('LaravelRedisFallback', LaravelRedisFallbackFacade::class);
        });
    }

    /**
     * Register
     *
     * @return mixed
     */
    public function register()
    {
        $this->app->singleton('cache', function($app) {
            return new LaravelRedisFallback($app);
        });

        $this->app->singleton('cache.store', function($app) {
            return $app['cache']->driver();
        });

        $this->app->singleton('memcached.connector', function() {
            return new MemcachedConnector;
        });

        $this->registerCommands();
    }
}
