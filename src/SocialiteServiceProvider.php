<?php

namespace CoreCMF\corecmf;

use Illuminate\Support\ServiceProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
      print_r('aaa');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

    }
}
