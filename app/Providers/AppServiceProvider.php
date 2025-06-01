<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Entidades\Sucursal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('web.*', function ($view) {
            $sucursalModel = new Sucursal();
            $aSucursales = $sucursalModel->obtenerTodos();
            $view->with('aSucursales', $aSucursales);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
