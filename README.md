<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel Advenced in this Project

### 1. Routing

Create project

`composer create-project --prefer-dist laravel/laravel laravel-advanced`

#### 1.1 Migration, Seed, Make Model Controller

Make model

`php artisan make:model Point`

`php artisan make:model Team`

`php artisan make:model Ticket`

Rerun all migration

`php artisan migrate:refresh --seed`

Get the old helpers

`composer require laravel/helpers`

#### 1.2 Custom namespaces

Make Controller

`php artisan make:controller Web/TeamController --resource --model=Team`

#### 1.3 Route macros

Build Service Provider for the Response Macro

`php artisan make:provider RouteMacroServiceProvider`

http://laravel.advanced/teams/1/title --> return title of the Team in JSON.

=> Can be use in the "API project"

#### 1.4 Route groups

```php
//Route::namespace('Web')->group(function (){
Route::group(['namespace' => 'Web', 'prefix' => 'testing'],function (){
    Route::resource('teams','TeamController');

    Route::get('/teams/{team}/title',function (\App\Team $team){
        return response()->jTitle($team);
    });
});
```
Url become: http://laravel.advanced/testing/teams/1/title

### 1.5 Named routes
```php
Route::get('/', function () {
    return view('welcome');
})->name('home');
```
