# Redis cache fallback for Laravel 5

If you use Redis as cache driver on Laravel 5 and for some reason Redis server became unavailable, you will end up with a Connection Refused exception.
This package simply checks for the connection and if test fails, cache is switched to file driver.
As soon as Redis come back it will be used again.

##How to use
Install LaravelRedisFallback as a Composer package, adding this line to your composer.json:

```php
"xtcat/laravel-redis-fallback": "dev-master"
```
and update your vendor folder running the ```composer update ``` command.

Replace the default cache service provider: 

```php
'providers' => array(
	...
	//'Illuminate\Cache\CacheServiceProvider',
	...
	'Xtcat\LaravelRedisFallback\LaravelRedisFallbackServiceProvider'
	...
)
```
##Events
You can listen to 'redis.unavailable' event in your listener, for example send an email to you when the redis server is down.

Enjoy!
