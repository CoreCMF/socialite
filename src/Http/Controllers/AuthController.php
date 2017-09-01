<?php

namespace CoreCMF\Socialite\Http\Controllers;

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

    public function __construct(Request $request, User $userRepo, SocialiteUser $socialiteUserRepo)
    {
        $this->request = $request;
        $this->userModel = $userRepo;
        $this->socialiteUserModel = $socialiteUserRepo;
    }
    /**
     * 将用户重定向到Github认证页面
     *
     * @return Response
     */
    public function redirectToProvider($service, $redirect=null)
    {

        $this->socialiteUserModel->$service = 123;
        $this->socialiteUserModel->user_id  = 6;
        dd($this->socialiteUserModel->save());
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
        $socialiteUser = Socialite::driver($service)->user();
        $users = $this->socialiteUserModel->where($service, $socialiteUser->id)->with('users')->first();
        if (empty($users)) {
            $this->createUser($service,$socialiteUser);
        }
        dd($users);
        return redirect($this->redirectUrl());//重定向
    }
    /**
     * 创建用户
     */
    private function createUser($service,$socialiteUser)
    {
        // $this->userModel->github = $socialiteUser->id;
        // $userModel->email = $user->email;
        // $userModel->name = $user->name;
        // $userModel->avatar = $user->avatar;
        // $this->userModel->save();
        // $this->userModel->email = $socialiteUser->email;
        $input = [
            'name' => $socialiteUser->name,
            'email' => $socialiteUser->email,
            'password' => str_random(10),//随机密码
            'nickname' => $socialiteUser->nickname,
        ];
        $user = $this->userModel->create($input);
        $this->socialiteUserModel->$service = $socialiteUser->id;
        $this->socialiteUserModel->user_id  = $user->id;
        $this->socialiteUserModel->save();
        dd($socialiteUser,$user);
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
