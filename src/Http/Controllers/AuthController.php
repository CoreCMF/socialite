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
        session(['redirect' => $redirect]);//传入授权后的重定向加密网址 存入session
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
        return redirect($this->redirectUrl());//重定向
    }
    /**
     * 重定向url
     */
    private function redirectUrl()
    {
        $redirect = $this->request->session()->get('redirect');
        return $redirect? decrypt($redirect): '/';
    }
}
