<?php

namespace CoreCMF\Socialite\App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MainController
{
    private $builderMain;
    /** return  CoreCMF\Core\Builder\Main */
    public function __construct()
    {
        $this->builderMain = resolve('builderMain')->event('socialiteMain');        //全局统一实例
    }
    public function index()
    {
        //缓存此次访问唯一id
        session(['uuid' => (string) Str::uuid()]);
        //配置前端路由
        $this->builderMain->route([
          'path'  =>  '/OAuth/Scan/:redirect?',
          'name'  =>  'OAuth.Scan',
          'apiUrl'  =>  route('api.socialite.scan'),
          'children' => null,
          'component' =>  '<socialite-scan/>'
        ]);
        $this->builderMain->route([
          'path'  =>  '/OAuth/Scan/Login/:uuid?',
          'name'  =>  'OAuth.Scan.Login',
          'apiUrl'  =>  route('api.socialite.scanLogin'),
          'children' => null,
          'component' =>  '<socialite-scanLogin/>'
        ]);
        $this->builderMain->route([
          'path'  =>  '/OAuth/Scan/Login/scanSuccess',
          'name'  =>  'OAuth.Scan.scanSuccess',
          'children' => null,
          'component' =>  '<socialite-scanSuccess/>'
        ]);
        //配置前端广播频道和广播方式
        $this->builderMain->config('broadcast', [
            'channel' => 'App.User.Login.'.session('uuid'),
            'type' => 'channel'
        ]);
        return resolve('builderHtml')->main($this->builderMain)->response();
    }
}
