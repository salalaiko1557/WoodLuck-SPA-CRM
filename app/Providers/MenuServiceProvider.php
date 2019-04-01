<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\MenuItem;
use Illuminate\Support\Facades\Auth;

class MenuServiceProvider extends ServiceProvider
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
        $this->generalMenu();
    }
    public function generalMenu(){
        View::composer('layouts.navigate', function($view){
            $data = [ 'logged_user' => \Auth::User()->name ];
            $view->with('menu', MenuItem::all())->with('username', $data);
        });
    }

}
