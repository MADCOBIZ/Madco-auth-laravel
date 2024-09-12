<?php

namespace Madco\AuthLogin;

use Illuminate\Support\ServiceProvider;

class AuthLoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            DIR . '/Config/authlogin.php' => config_path('authlogin.php'),
        ]);

        $this->loadRoutesFrom(DIR . '/routes/web.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            DIR . '/Config/authlogin.php', 'authlogin'
        );

        $this->app->singleton(CustomAuthService::class, function () {
            return new CustomAuthService();
        });
    }
}