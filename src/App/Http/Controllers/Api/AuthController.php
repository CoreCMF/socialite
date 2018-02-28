<?php

namespace CoreCMF\Socialite\App\Http\Controllers\Api;

use Auth;
use Illuminate\Support\Str;
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
        $uuid = (string) Str::uuid();
        $QRcode = route('OAuth.scan.login') . DIRECTORY_SEPARATOR . $uuid;
        $this->builderHtml->config('QRcode', $QRcode);
        return $this->builderHtml->response();
    }
}
