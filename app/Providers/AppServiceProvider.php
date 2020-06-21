<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStringLength(191);
        \Blade::directive('inputTextBox',function($field){
            return "<?php echo \App\InputBox::text($field); ?>";
        });
        \View::composer('*', 'App\TeamPointsComposer');
    }
}
