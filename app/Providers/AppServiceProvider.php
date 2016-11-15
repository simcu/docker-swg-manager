<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            $u = User::find($parameters[0]);
            return Hash::check($value, $u->password);
        });

        Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            return Session::get('captcha') == $value;
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
