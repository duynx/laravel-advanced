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

Controller: app/Http/Controllers/Web/TeamController.php
```php
public function points(Team $team)
{
    $sum = $team->where('teams.id', $team->id)
        ->join('tickets', 'teams.id', '=', 'tickets.team_id')
        ->join('points', 'tickets.id', '=', 'points.ticket_id')
        ->sum('points.value');
    return response()->json($sum);
}
```

Route

```php
Route::get('/teams/{team}/points', 'TeamController@points');
```

Url: http://laravel.advanced/teams/4/points

### 2.6 Service injection

Create file: app/Teams/Repository.php
```php
namespace App\Teams;

class Repository
{
    public function points($team)
    {
        return $team->where('teams.id', $team->id)
            ->join('tickets', 'teams.id', '=', 'tickets.team_id')
            ->join('points', 'tickets.id', '=', 'points.ticket_id')
            ->sum('points.value');
    }
}
```

Edit controller: app/Http/Controllers/Web/TeamController.php
```php
// Add 
public function __construct(\App\Teams\Repository $teams)
{
    $this->teams = $teams;
}

// Edit
public function points(Team $team)
{
    return response()->json($this->teams->points($team));
}
```
Url: http://laravel.advanced/teams/4/points -> the same result as 2.5

Notice we're able to both isolate logic in a different class that we can reuse across our application as well as inject the version we want. This now makes our instance of the team repository class replaceable at runtime, making this much easier for us to do any unit testing in this class. Since we can set the constructor argument and replace the repository with the mock if we need to.

## 3. Authentication and Authorization

### 3.1 Custom user guards

app/Providers/AuthServiceProvider.php
```php
public function boot()
{
    $this->registerPolicies();
    $this->registerPolicies();
    \Auth::viaRequest('email', function($request){
        return \App\User::where('email', $request->email)->first();
    });
}
```

config/auth.php
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'token',
        'provider' => 'users',
        'hash' => false,
    ],

    'email' => [
        'driver' => 'email',
        'provider' => 'users',
    ],
]
```

routes/web.php
```php
Route::get('/square/{number?}',function ($number = 10){
    return $number * $number;
})->middleware('auth:email');
```

http://laravel.advanced/square/5?email=nguyenduy1324@gmail.com

### 3.2 Custom user gating

User gating is the mechanism in Laravel to determine if a user can perform a particular action. Let's say that we want to update our logic to teams to permit only a member of team to perform actions on that same team. We can define gates in a variety of ways

`php artisan make:policy TeamPolicy --model=Team`

app/Policies/TeamPolicy.php
```php
public function view(User $user, Team $team)
{
    return ($user->team_id === $team->id);
}

public function create(User $user)
{
    return true;
}
```
app/Providers/AuthServiceProvider.php
```php
protected $policies = [
    // 'App\Model' => 'App\Policies\ModelPolicy',
    'App\Team' => 'App\Policies\TeamPolicy',
];
```
app/Http/Controllers/Web/TeamController.php
```php
public function __construct(\App\Teams\Repository $teams)
{
    $this->teams = $teams;
    $this->authorizeResource(Team::class, 'team');
}

public function points(Team $team)
{
    $this->authorize('view', $team);
    return response()->json($this->teams->points($team));
}
```
http://laravel.advanced/teams/create

-> http://laravel.advanced/teams/1: 

we'll see that we get a 403 error. That's because our user account isn't associated with the team of ID of 1

### 3.3 Before user gating

