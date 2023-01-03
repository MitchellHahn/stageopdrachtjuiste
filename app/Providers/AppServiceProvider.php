<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;
use App\Models\Navbar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * voor navbar zzper module
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
// bepaalde pagina tonen voor bepaalde account_type
        View::composer('*', function($view)
        {
            $navbars = Navbar::where('account_type', \Auth::user()?->account_type)->orderBy('ordering')->get();

            $view->with('navbars', $navbars);
            $view->with('loggedInUser', \Auth::user());
        });
    }
}
