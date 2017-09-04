<?php

namespace CoreCMF\Socialite\Listeners;

class SocialiteEventSubscriber
{
    /**
     * 处理BuilderForm登录页面渲染
     * @translator laravelacademy.org
     */
    public function onBuilderFormLogin($event)
    {
        $event->form->item(['name' => 'password',      'type' => 'password',    'placeholder' => '请输入账户密码']);
    }

    /**
     * 处理用户退出事件.
     */
    public function onUserLogout($event) {

    }

    /**
     * 为订阅者注册监听器.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'CoreCMF\Core\Events\BuilderForm',
            'CoreCMF\Socialite\Listeners\SocialiteEventSubscriber@onBuilderFormLogin'
        );
    }

}
