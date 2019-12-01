<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //
        /*view()->composer(['backend.home.index'], function ($view) {
            $data['_admin']=auth()->guard('admin')->user();
            $test = new \App\Http\Controllers\Backend\Home;
            $data['_menus'] = $test->Menus($data['_admin']);
            $view->with($data);
        });*/
    }
}
