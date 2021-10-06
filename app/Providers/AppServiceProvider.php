<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
<<<<<<< HEAD
         if (config('app.env') === 'production') {
                URL::forceScheme('https');
        }
=======
       if (config('app.env') === 'production') {
    URL::forceScheme('https');
}
>>>>>>> 64b1f2d (add Force https)
        Validator::extend('alpha_spaces', function ($attribute, $value) {

            // This will only accept alpha and spaces. 
            //https://stackoverflow.com/questions/34099777/laravel-5-1-validation-rule-alpha-cannot-take-whitespace
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value); 
    
        });
        Paginator::useBootstrap();
       
    }
}
