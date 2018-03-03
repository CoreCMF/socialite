<?php

namespace CoreCMF\Socialite\App\Listeners;

use CoreCMF\Socialite\App\Models\Config;

/**
 * [SocialiteEventSubscriber 社会登录事件订阅者]
 */
class SocialiteEventSubscriber
{
    private $configModel;

    public function __construct(Config $configPro)
    {
        $this->configModel = $configPro;
    }
    /**
     * 处理BuilderForm登录页面渲染
     * 监听BuilderForm事件下的login事件
     * @translator laravelacademy.org
     */
    public function onBuilderFormLogin($event)
    {
        $form = $event->form;
        if ($form->event == 'login') {
            $html = null;
            $redirect = array_key_exists('redirect', $form->config)? encrypt($form->config['redirect']): null;
            $configs = $this->configModel->where('status', 1)->get();
            foreach ($configs as $key => $config) {
                $url = route('OAuth.redirect', [
                    'service' => $config['service'],
                    'redirect' => $redirect,
                ]);
                $html .= '<a href="'.$url.'">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-'.$config['service'].'"></use>
                            </svg>
                          </a>';
            }
            $form->htmlEnd('
                    <div class="socialite">
                        <a href="'.route('OAuth.scan', [
                            'redirect' => $redirect,
                        ]).'">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-scan"></use>
                            </svg>
                        </a>
                      '.$html.'
                    </div>
                  ');
        }
    }
    /**
     * [onBuilderTablePackage 后台模型table渲染处理]
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    public function onBuilderTablePackage($event)
    {
        $table = $event->table;
        if ($table->event == 'adminPackage') {
            $table->data->transform(function ($item, $key) {
                if ($item->name == 'Socialite') {
                    $item->rightButton = [
                        [
                            'title'=>'配置编辑',
                            'apiUrl'=> route('api.socialite.admin.config.index'),
                            'type'=>'info',
                            'icon'=>'fa fa-edit',
                            'method'=>'dialog'
                        ]
                    ];
                }
                return $item;
            });
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
            'CoreCMF\Core\Support\Events\BuilderForm',
            'CoreCMF\Socialite\App\Listeners\SocialiteEventSubscriber@onBuilderFormLogin'
        );
        $events->listen(
            'CoreCMF\Core\Support\Events\BuilderTable',
            'CoreCMF\Socialite\App\Listeners\SocialiteEventSubscriber@onBuilderTablePackage'
        );
    }
}
