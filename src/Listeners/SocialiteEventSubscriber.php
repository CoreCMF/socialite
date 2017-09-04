<?php

namespace CoreCMF\Socialite\Listeners;
/**
 * [SocialiteEventSubscriber 社会登录事件订阅者]
 */
class SocialiteEventSubscriber
{
    /**
     * 处理BuilderForm登录页面渲染
     * 监听BuilderForm事件下的login事件
     * @translator laravelacademy.org
     */
    public function onBuilderFormLogin($event)
    {
        $form = $event->form;
        if ($form->event == 'login') {
            $form->item([
                    'type' => 'html',
                    'style' => [ 'margin-bottom'=> '25px', 'text-align'=>'center' ],
                    'data' => '
                      <svg class="icon" aria-hidden="true">
                          <use xlink:href="#icon-social-blogger"></use>
                      </svg>
                    <img src="http://vueadmin.hinplay.com/static/images/a5ceee8b.png">'
                  ]);
        }
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
