<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
	 
	public function boot(UrlGenerator $url)
    {
		 \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        \Carbon\Carbon::setLocale($this->app->getLocale());
		
        if(env('REDIRECT_HTTPS')) {
            $url->formatScheme('https');
        }
    } 

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
		}
    }
}
