<?php

namespace CoreCMF\Socialite\App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\Socialite\App\Models\Config;
use CoreCMF\Socialite\App\Events\LoginBroadcasting;

class AuthController extends Controller
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
     * [scanLogin pc手机扫码登录]
     * @param    [type]         $redirect [回调网址]
     * @return   [type]                   [description]
     * @Author   bigrocs
     * @QQ       532388887
     * @Email    bigrocs@qq.com
     * @DateTime 2018-02-04
     */
    public function scan()
    {
        $sessionId = session()->getId();
        $QRcode = route('OAuth.Scan.wap') . DIRECTORY_SEPARATOR . $sessionId;
        $this->builderHtml->config('QRcode', $QRcode);

        return $this->builderHtml->response();
    }
    /**
     * [scanWapLogin wap扫码后页面]
     * @param    [type]         $id [description]
     * @return   [type]             [description]
     * @Author   bigrocs
     * @QQ       532388887
     * @Email    bigrocs@qq.com
     * @DateTime 2018-02-04
     */
    // public function scanWapLogin($sessionId)
    // {
    //     if (Auth::id()) {
    //         event(new LoginBroadcasting($sessionId));//登录成功广播事件
    //         // dd($_COOKIE['laravel_session']);
    //         // dd(session('userId'), session()->getId());
    //     }
    //     dd('a');
    //     $configs = $this->configModel->where('status', 1)->get();
    //     $socialite = $configs->mapWithKeys(function ($config) use ($sessionId) {
    //         return [
    //             $config['service'] => route('OAuth.redirect', [
    //                 'service' => $config['service'],
    //                 'redirect' => encrypt(route('OAuth.Scan.wap').DIRECTORY_SEPARATOR.$sessionId)
    //             ])
    //         ];
    //     })->toArray();
    //     return view('socialite::scanWapLogin', ['socialite' => $socialite]);
    // }
}
