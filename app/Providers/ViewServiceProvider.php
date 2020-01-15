<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

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
        view()->composer(['frontend.common.index'], 'App\Http\Views\Frontend');
        view()->composer(['frontend.common.side'], 'App\Http\Views\Frontend');
        view()->composer(['frontend.account.login'], 'App\Http\Views\Frontend');
        view()->composer(['frontend.account.register'], 'App\Http\Views\Frontend');
        view()->composer(['frontend.account.reset'], 'App\Http\Views\Frontend');
    }

}