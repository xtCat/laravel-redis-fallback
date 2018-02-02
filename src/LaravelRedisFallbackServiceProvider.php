<?php

namespace guillermobt\LaravelRedisFallback;

use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Cache\MemcachedConnector;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Cache\Console\ClearCommand;

/**
 * Redis fallback service provider
 *
 * @package Xtcat
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
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
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
        $this->app->singleton('cache', function ($app) {
            return new LaravelRedisFallback($app);
        });

        $this->app->singleton('cache.store', function ($app) {
            return $app['cache']->driver();
        });

        $this->app->singleton('memcached.connector', function () {
            return new MemcachedConnector;
        });
        
        if (floatval(\App::version()) < 5.4) {
            $this->registerCommands();
        }
    }
    
    /**
     * Register the cache related console commands.
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->app->singleton('command.cache.clear', function ($app) {
            return new ClearCommand($app['cache']);
        });

        $this->commands('command.cache.clear');
    }
}
