# Redis cache fallback for Laravel 5

If you use Redis as cache driver on Laravel 5 and for some reason Redis server became unavailable, you will end up with a Connection Refused exception.
This package simply checks for the connection and if test fails, cache is switched to file driver.
As soon as Redis come back it will be used again.

##How it works
```LaravelRedisFallbackServiceProvider``` class extends ```Illuminate\Cache\CacheServiceProvider``` and overrides ```register()``` method as follow:
```php
	public function register(){

		$this->app->bindShared('cache', function($app){
			return new \Davidepedone\LaravelRedisFallback\LaravelRedisFallback($app);
		});
		...
	}
```
```LaravelRedisFallback``` class extends ```Illuminate\Cache\CacheManager``` and overrides ```createRedisDriver()``` method as follow:
```php

    protected function createRedisDriver() {

        $redis = $this->app['redis'];
        $redisStore = new RedisStore($redis, $this->getPrefix());

        try{

            $redisStore->getRedis()->ping();
            return $this->repository( $redisStore );

        }catch(\Exception $e){

            return parent::createFileDriver();
        }
        
    }

```

##How to use
Install LaravelRedisFallback as a Composer package, adding this line to your composer.json:

```php
"davidepedone/laravel-redis-fallback": "dev-master"
```
and update your vendor folder running the ```composer update ``` command.

Replace the default cache service provider: 

```php
'providers' => array(
	...
	//'Illuminate\Cache\CacheServiceProvider',
	...
	'Davidepedone\LaravelRedisFallback\LaravelRedisFallbackServiceProvider'
	...
)
```

Enjoy!
