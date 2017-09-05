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
        //设置发布前端文件
        $this->publishes([
            __DIR__.'/../resources/vendor/' => public_path('vendor'),
        ], 'socialite');
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
        $this->viewShare();
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
    /**
     * [viewShare 视图共享数据]
     * @return [type] [description]
     */
    public function viewShare()
    {
        $builderAsset = resolve('builderAsset');
        $builderAsset->css(asset('/vendor/socialite/css/app.css'));
        $builderAsset->js(asset('/vendor/socialite/js/iconfont.js'));
        view()->share('resources', $builderAsset->response());//视图共享数据
    }
}
