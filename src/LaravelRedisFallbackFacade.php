<?php

namespace xtCat\LaravelRedisFallback;

use Illuminate\Support\Facades\Facade;

/**
 * Redis fallback facade
 *
 * @package xtCat
 * @subpackage LaravelRedisFallback
 *
 * @author Davide Pedone <davide.pedone@gmail.com>
 * @author Peter Otto <peterotto87@gmail.com>
 */
class LaravelRedisFallbackFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-redis-fallback';
    }
}
