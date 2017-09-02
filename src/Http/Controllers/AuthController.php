<?php

namespace CoreCMF\Socialite\Http\Controllers;

use Auth;
use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\Socialite\Models\User as SocialiteUser;
use CoreCMF\Core\Models\User;

class AuthController extends Controller
{
    private $request;
    private $userModel;
    private $socialiteUserModel;

    public function __construct(
      Request $request,
      User $userRepo,
      SocialiteUser $socialiteUserRepo
    )
    {
        $this->request = $request;
        $this->userModel = $userRepo;
        $this->socialiteUserModel = $socialiteUserRepo;
    }
    /**
     * 将用户重定向到Provider认证页面
     *
     * @return Response
     */
    public function redirectToProvider($service, $redirect=null)
    {
        $this->request->session()->put('redirect', $redirect);//传入授权后的重定向加密网址 存入session
        return Socialite::driver($service)->with(['hd' => 'example.com'])->redirect();
    }

    /**
     * 从Provider获取用户信息.
     *
     * @return Response
     */
    public function handleProviderCallback($service)
    {
        $socialiteUser = Socialite::driver($service)->user();
        $socialite = $this->socialiteUserModel->where($service, $socialiteUser->id)->with('users')->first();
        if (empty($socialite)) {
            $user = $this->createUser($service,$socialiteUser);//创建用户
        }else{
            $user = $socialite->users;
        }
        Auth::login($user);
        return redirect($this->redirectUrl());//重定向
    }
    /**
     * 创建用户
     */
    private function createUser($service,$socialiteUser)
    {
        $user = Auth::user();//获取当前用户 如果没有用户注册新用户
        if (!$user) {
            $input = [
                'name' => $socialiteUser->name,
                'email' => $socialiteUser->email,
                'password' => str_random(10),//随机密码
                'nickname' => $socialiteUser->nickname,
            ];
            $user = $this->userModel->create($input);//创建用户
        }
        // 关联用户
        $this->socialiteUserModel->$service = $socialiteUser->id;
        $this->socialiteUserModel->user_id  = $user->id;
        return $this->socialiteUserModel->save()? $user: false;
    }
    /**
     * 重定向url
     */
    private function redirectUrl()
    {
        $redirect = $this->request->session()->get('redirect');
        return $redirect? decrypt($redirect): '/'; //解密重定向网址
    }
}
