<?php

namespace Awcode\MondayPHP;

use Illuminate\Support\ServiceProvider;

class MondayPHPServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('monday-php',function(){
            return new \Awcode\MondayPHP\MondayPHP();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/monday.php' => config_path('monday.php'),
        ], 'config');
        
        
    }
}
//Service provider options listed @ https://laravel.com/docs/8.x/packages
