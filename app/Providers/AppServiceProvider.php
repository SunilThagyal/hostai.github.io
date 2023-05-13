<?php

namespace App\Providers;

use App\View\Components\AlertComponent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::component('alert', AlertComponent::class);

        view()->composer('*', function($view)
        {
            if(!is_null(auth()->user())) {
                $authUser = auth()->user();
                $view->with('authUser', $authUser);
            }
        });
    }
}
