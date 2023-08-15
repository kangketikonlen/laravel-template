<?php

namespace App\Providers;

use App\Models\System\Module;
use App\Models\System\Navbar;
use App\Models\System\AppInfo;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        View::composer('*', function ($view) {
            $navbars = Navbar::get();
            $appInfo = AppInfo::first();
            $modules = Module::get();
            $view->with('navbars', $navbars);
            $view->with('appInfo', $appInfo);
            $view->with('modules', $modules);
        });
        Paginator::useBootstrapFive();
    }
}
