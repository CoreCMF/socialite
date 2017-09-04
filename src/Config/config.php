<?php

return [
    'providers' => [
        Laravel\Socialite\SocialiteServiceProvider::class,
        CoreCMF\Socialite\Providers\EventServiceProvider::class,//事件服务
    ],
];
