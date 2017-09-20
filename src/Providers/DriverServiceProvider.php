<?php

namespace CoreCMF\Socialite\Providers;

use Illuminate\Support\ServiceProvider;
use CoreCMF\Socialite\App\Driver\Qq;
use CoreCMF\Socialite\App\Driver\Wechat;
use CoreCMF\Socialite\App\Driver\WechatWeb;
use CoreCMF\Socialite\App\Driver\Weibo;
use CoreCMF\Socialite\App\Driver\Douban;

class DriverServiceProvider extends ServiceProvider
{
    public function boot()
    {
         $this->app->make('Laravel\Socialite\Contracts\Factory')->extend('qq', function ($app) {
              $config = $app['config']['services.qq'];
              return new Qq(
                  $app['request'], $config['client_id'],
                  $config['client_secret'], $config['redirect']
              );
         })->extend('wechat', function ($app) {
              $config = $app['config']['services.wechat'];
              return new Wechat(
                  $app['request'], $config['client_id'],
                  $config['client_secret'], $config['redirect']
              );
         })->extend('wechatweb', function ($app) {
              $config = $app['config']['services.wechatweb'];
              return new WechatWeb(
                  $app['request'], $config['client_id'],
                  $config['client_secret'], $config['redirect']
              );
         })->extend('weibo', function ($app) {
              $config = $app['config']['services.weibo'];
              return new Weibo(
                  $app['request'], $config['client_id'],
                  $config['client_secret'], $config['redirect']
              );
         })->extend('douban', function ($app) {
              $config = $app['config']['services.douban'];
              return new Douban(
                  $app['request'], $config['client_id'],
                  $config['client_secret'], $config['redirect']
              );
         });
    }
    public function register()
    {

    }
}
