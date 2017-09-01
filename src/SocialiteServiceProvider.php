<?php

namespace CoreCMF\Socialite;

use Illuminate\Support\ServiceProvider;
use Socialite;
class SocialiteServiceProvider extends ServiceProvider
{
    protected $commands = [
        \CoreCMF\Socialite\Commands\InstallCommand::class,
        \CoreCMF\Socialite\Commands\UninstallCommand::class,
    ];
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Socialite $Socialite)
    {
        //加载artisan commands
        $this->commands($this->commands);
        //配置路由
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        //迁移文件配置
        $this->loadMigrationsFrom(__DIR__.'/Databases/migrations');
        // 加载配置
        $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'socialite');
        $this->initService();

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

    }
    /**
     * 初始化服务
     */
    public function initService()
    {
        $github = [
            'client_id' => '8aeca72d03782ea999ad',
            'client_secret' => '68b41095d1723798590ed3f0452a9c91dec92e05',
            'redirect' => 'http://corecmf.dev/OAuth/github/callback',
        ];
        config(['services.github' => $github]);
        //注册providers服务
        $this->registerProviders();
    }
    /**
     * 注册引用服务
     */
    public function registerProviders()
    {
        $providers = config('socialite.providers');
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }
}
