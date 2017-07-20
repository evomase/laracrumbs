# Laracrumbs
Laracrumbs is a lightweight Laravel package that provides the functionality to add 
[Breadcrumbs](https://en.wikipedia.org/wiki/Breadcrumb_(navigation)) to [Routes](https://laravel.com/docs/master/routing)

## Requirements
- PHP 7.0
- Laravel 5.4+

## Installation
To get started, install Laracrumbs via Composer

```sh
composer require evomase/laracrumbs
```

Next, is to register the Laracrumbs service provider to the `providers` array of your 
`config/app` configuration file:

```php
Laracrumbs\Providers\ServiceProvider::class
```

## Basic Usage

### Register
Breadcrumbs are created by using the registered routes and defining a `callback` to return
the title for each segment. The following example below shows how this can be done

```php
//Create Route
$route = Route::get('/', 'Controller@method');

//Add route to Breadcrumb
Breadcrumbs::add($route, function(){
    return 'Home';
});
```
All parameters assigned to a route will also be passed to the `callback` enabling you to
customize the return value further. Also, objects in the service container are 
automatically injected in the callback as shown in the example below.

```php
$route = Route::get('users/{user}/edit', 'Controller@method');
Breadcrumbs::add($route, function(App\User $user, Illuminate\Container $app){
   // return a string
});
```

### Render
A breadcrumbs view has been added which can be included in any view template. 
Once included, it will automatically generate the breadcrumbs associated to the
current request.

```php
<div class="container">
    @include('laracrumbs::breadcrumbs')
</div>
```

> A copy of the breadcrumbs views template can be found in `resources\views\vendor`

## License
Laracrumbs is open-sourced software licensed under the MIT license