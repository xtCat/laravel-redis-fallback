# Note about this fork

This is forked from xcat/laravel-redis-fallback to fix an issue with Laravel versions 5.0 to 5.3 related to the lost functionality of the command: php artisan cache:clear

Xtcat will be creating a new branch to solve it.

# Redis cache fallback for Laravel 5

If you use Redis as cache driver on Laravel 5 and for some reason Redis server became unavailable, you will end up with a Connection Refused exception.
This package simply checks for the connection and if test fails, cache is switched to file driver.
As soon as Redis come back it will be used again.

## How to use
Install LaravelRedisFallback as a Composer package, adding this line to your composer.json:

```php
"guillermobt/laravel-redis-fallback": "dev-master"
```
and update your vendor folder running the ```composer update ``` command.

Replace the default cache service provider: 

```php
'providers' => array(
	...
	//'Illuminate\Cache\CacheServiceProvider',
	...
	\guillermobt\LaravelRedisFallback\LaravelRedisFallbackServiceProvider::class
	...
)
```
## Events
You can listen to 'redis.unavailable' event in your listener, for example send an email to you when the redis server is down.

Enjoy!
