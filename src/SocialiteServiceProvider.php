<?php

namespace CoreCMF\Socialite;

// use AliasLoader;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use CoreCMF\Socialite\App\Models\Config;

class SocialiteServiceProvider extends ServiceProvider
{
    protected $commands = [
        \CoreCMF\Socialite\App\Console\InstallCommand::class,
        \CoreCMF\Socialite\App\Console\UninstallCommand::class,
    ];
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //加载artisan commands
        $this->commands($this->commands);
        //配置路由
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/channels.php');
        //迁移文件配置
        $this->loadMigrationsFrom(__DIR__.'/Databases/migrations');
        //视图路由
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'socialite');
        //设置发布前端文件
        $this->publishes([
            __DIR__.'/../resources/vendor' => public_path('vendor'),
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
        $config = new Config();
        $config->configRegister();//注册配置信息
        $this->viewShare();
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
