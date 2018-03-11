<?php

namespace CoreCMF\Socialite\App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use CoreCMF\Socialite\App\Models\Config;
use CoreCMF\Socialite\App\Events\LoginBroadcasting;

class AuthController
{
    private $request;
    private $configModel;
    private $builderHtml;

    public function __construct(
      Request $request,
      Config $configRepo
    ) {
        $this->request = $request;
        $this->configModel = $configRepo;
        $this->builderHtml = resolve('builderHtml')->event('socialiteAuth');        //全局统一实例
    }
    /**
     * [scan pc手机扫码登录]
     * @param    [type]         $redirect [回调网址]
     * @return   [type]                   [description]
     * @Author   bigrocs
     * @QQ       532388887
     * @Email    bigrocs@qq.com
     * @DateTime 2018-02-04
     */
    public function scan()
    {
        $QRcode = route('OAuth.scan.login') . DIRECTORY_SEPARATOR . session('uuid');
        $this->builderHtml->config('QRcode', $QRcode);
        return $this->builderHtml->response();
    }
    /**
     * [scanLogin wap手机扫码登录]
     * @return   [type]         [description]
     * @Author   bigrocs
     * @QQ       532388887
     * @Email    bigrocs@qq.com
     * @DateTime 2018-03-11
     */
    public function scanLogin()
    {
        $uuid = session('uuid');
        event(new LoginBroadcasting($uuid));//登录成功广播事件
        $configs = $this->configModel->where('status', 1)->get();
        $socialite = $configs->mapWithKeys(function ($config) use ($uuid) {
            return [
                $config['service'] => route('OAuth.redirect', [
                    'service' => $config['service'],
                    'redirect' => encrypt(route('OAuth.scan.login').DIRECTORY_SEPARATOR.$uuid)
                ])
            ];
        })->toArray();
        $this->builderHtml->config('socialite', $socialite);
        return $this->builderHtml->response();
    }
}
