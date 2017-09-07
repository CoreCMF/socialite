<?php

namespace CoreCMF\Socialite\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Container\Container;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    public function __construct(){
    }
    public function index(Request $request)
    {
        dd('aa');
        $html = $this->container->make('builderHtml')
                  ->title('配置管理')
                  ->response();
        return $html;
    }

}
