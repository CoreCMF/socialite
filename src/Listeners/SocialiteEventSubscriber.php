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
            $url = '/OAuth/service/';
            $url = str_replace("service","github",$url); //驱动替换后期放到model里面处理
            $redirect = array_key_exists('redirect',$form->config)? encrypt($form->config['redirect']): null;
            if ($redirect) {
                $url .= $redirect;
            }
            $form->htmlEnd('
                    <div class="socialite">
                      <a href="'.$url.'">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-social-github"></use>
                        </svg>
                      </a>
                      <a href="">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-social-qq"></use>
                        </svg>
                      </a>
                      <a href="">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-social-wechat"></use>
                        </svg>
                      </a>
                      <a href="">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-social-wechat"></use>
                        </svg>
                      </a>
                      <a href="">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-social-wechat"></use>
                        </svg>
                      </a>
                    </div>
                  ');
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
