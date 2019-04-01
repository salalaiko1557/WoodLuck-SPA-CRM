<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->userRole();
    }
    public function userRole(){
        // if(Auth::User()){
            View::composer('layouts.app', function($view){
                if(Auth::User()){
                    $view->with('role', \Auth::User()->role);
                }else{
                    $view->with('role', 0);
                }
            });
        // }

    }
}
