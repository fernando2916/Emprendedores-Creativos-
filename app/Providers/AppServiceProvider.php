<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer([
        'components.layouts.principal',
    ], function ($view) {

        $listaDeseosCount = 0;

        if (Auth::check()) {
            $listaDeseosCount = Auth::user()
                ->listaDeseos()
                ->count();
        }

        $view->with(
            'listaDeseosCount',
            $listaDeseosCount
        );
    });
    }
}