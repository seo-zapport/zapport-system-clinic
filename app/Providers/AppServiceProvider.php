<?php

namespace App\Providers;

use App\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
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
        schema::defaultStringLength(191);

        Request::macro('breadcrumbs', function (){
            return new Breadcrumbs($this);
        });
    }
}
