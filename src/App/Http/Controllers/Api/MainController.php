<?php

namespace CoreCMF\Socialite\App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
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
          'name'  =>  'admin.login',
          'apiUrl'  =>  route('api.socialite.scan'),
          'children' => null,
          'component' =>  '<socialite-scan/>'
        ]);
        //配置前端广播频道和广播方式
        $this->builderMain->config('broadcast', [
            'channel' => 'App.User.Login.'.session('uuid'),
            'type' => 'private'
        ]);
        return resolve('builderHtml')->main($this->builderMain)->response();
    }
}
