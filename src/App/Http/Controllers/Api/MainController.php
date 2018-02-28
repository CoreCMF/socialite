<?php

namespace CoreCMF\Socialite\App\Http\Controllers\Api;

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
        $this->builderMain->route([
          'path'  =>  '/OAuth/Scan/:redirect?',
          'name'  =>  'admin.login',
          'apiUrl'  =>  route('api.socialite.scan'),
          'children' => null,
          'component' =>  '<socialite-scan/>'
        ]);

        return resolve('builderHtml')->main($this->builderMain)->response();
    }
}
