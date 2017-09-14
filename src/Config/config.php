<?php

return [
    'name' => 'Socialite',
    'title' => '社会第三方登录',
    'description' => '社会第三方登录插件,引用Laravel\Socialite服务,可以实现QQ、微信、新浪、淘宝、支付宝、github等主流第三方登录。',
    'author' => 'BigRocs',
    'version' => 'v1.1.6',
    'serviceProvider' => CoreCMF\Socialite\SocialiteServiceProvider::class,
    'install' => 'corecmf:socialite:install',//安装artisan命令
    'providers' => [
        Laravel\Socialite\SocialiteServiceProvider::class,
        CoreCMF\Socialite\Providers\EventServiceProvider::class,//事件服务
        CoreCMF\Socialite\Providers\DriverServiceProvider::class,//驱动服务
    ],
];
