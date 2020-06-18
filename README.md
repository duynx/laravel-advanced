<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Learning Laravel Advanced in this Project

## 1. Routing

Create project

`composer create-project --prefer-dist laravel/laravel laravel-advanced`

### 1.1 Migration, Seed, Make Model Controller

Make model

`php artisan make:model Point`

`php artisan make:model Team`

`php artisan make:model Ticket`

Rerun all migration

`php artisan migrate:refresh --seed`

Get the old helpers

`composer require laravel/helpers`

### 1.2 Custom namespaces

Make Controller

`php artisan make:controller Web/TeamController --resource --model=Team`

### 1.3 Route macros

Build Service Provider for the Response Macro

`php artisan make:provider RouteMacroServiceProvider`

http://laravel.advanced/teams/1/title --> return title of the Team in JSON.

=> Can be use in the "API project"

### 1.4 Route groups

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
### 1.6 Signed routes
```php
Route::get('/teams/{team}/activate', function (){
        return view('team/activate');
    })->name('activateTeam')->middleware('signed');

// View
echo URL::temporarySignedRoute('activateTeam', now()->addMinute(1),['team' => 1]);
```
### 1.7 Default route values
```php
Route::get('/square/{number?}',function ($number = 10){
    return $number * $number;
});
// http://laravel.advanced/square/5
```

## 2. Controllers

### 2.1 Request validation

Make request

`php artisan make:request StoreTeam`

app/Http/Requests/StoreTeam.php
```php
public function rules()
{
    return [
        'title' => 'required|unique:teams|max:255',
    ];
}
``` 
app/Http/Controllers/Web/TeamController.php
```php
public function store(\App\Http\Requests\StoreTeam $request)
{
    $team = new Team();
    $team->title = $request->input('title');
    $team->save();
    return redirect('/teams');
}
```
 
 ### 2.2 Validation testing
 
 Using Dusk - Browser based test
 
`composer require --dev laravel/dusk`

`php artisan dusk:install`

`php artisan dusk:make TeamCreatetest`

File: tests/Browser/TeamCreateTest.php
```php
public function testCreatePass()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/teams/create')
            ->type('title', 'SampleTeam')
            ->press('Create')
            ->assertPathIs('/teams');
    });
}

public function testCreateFail()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/teams/create')
            ->type('title', '')
            ->press('Create')
            ->assertPathIs('/teams/create');
    });
}
```

Run test

`php artisan dusk`

### 2.3 Request authorization

Authentication Quickstart

`composer require laravel/ui`

`php artisan ui vue --auth`

`npm install && npm run dev`

Go to: http://laravel.advanced/register

nguyenduy1324@gmail.com/12345678

In: app/Http/Requests/StoreTeam.php
```php
public function authorize()
{
    return ($this->user()->team_id == null);
    //return ($this->user()->team_id !== null);
}
```

Create a team to test: http://laravel.advanced/teams/create


 So this is the path forward in the future when we need to ensure that a page can only be access by a certain set of users, you can customize the request object the controller action uses.
 
 ### 2.4 Exception rendering
 
 Make Exception
 
 `php artisan make:exception ActionNotCompletedException`
 
 File: app/Exceptions/ActionNotCompletedException.php
 
 ```php
class ActionNotCompletedException extends Exception
{
    public function render($request)
    {
        return response()->view('no_method', [], 501);
    }
}
```
In: app/Http/Controllers/Web/TeamController.php
```php
public function edit(Team $team)
{
    throw new \App\Exceptions\ActionNotCompletedException();
}
```
Access to test: http://laravel.advanced/teams/1/edit

### 2.5 Beyond a resource controller


