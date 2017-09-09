<?php

namespace CoreCMF\Socialite\Providers;

use Illuminate\Support\ServiceProvider;
use CoreCMF\Socialite\Driver\QqProvider;

class DriverServiceProvider extends ServiceProvider
{
    public function boot()
    {
         $this->app->make('Laravel\Socialite\Contracts\Factory')->extend('qq', function ($app) {
              $config = $app['config']['services.qq'];
              return new QqProvider(
                  $app['request'], $config['client_id'],
                  $config['client_secret'], $config['redirect']
              );
         });
    }
    public function register()
    {

    }
}
