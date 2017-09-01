<?php

namespace CoreCMF\Socialite\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
      private $request;

      public function __construct(Request $request)
      {
          $this->request = $request;
      }
    /**
     * 将用户重定向到Github认证页面
     *
     * @return Response
     */
    public function redirectToProvider($service, $redirect=null)
    {
        session(['redirect' => $redirect]);//传入授权后的跳转网址
        return Socialite::driver($service)->with(['hd' => 'example.com'])->redirect();
    }

    /**
     * 从Github获取用户信息.
     *
     * @return Response
     */
    public function handleProviderCallback($service)
    {
        $user = Socialite::driver($service)->user();
        dd($user);
        return redirect($this->redirect());
    }
    private function redirect()
    {
        $redirect = $this->request->session()->get('redirect');
        if ($redirect) {
            return decrypt($redirect);//解密重定向网址
        }else{
            return '/';
        }
    }
}
