<?php

namespace CoreCMF\Socialite\App\Http\Controllers;

use Auth;
use Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\Socialite\App\Models\User as SocialiteUser;
use CoreCMF\Socialite\App\Models\Config;
use CoreCMF\Core\App\Models\User;
use CoreCMF\Core\App\Models\Upload;
use CoreCMF\Core\App\Models\PassportClient;
use CoreCMF\Socialite\App\Events\LoginBroadcasting;

class AuthController extends Controller
{
    private $request;
    private $userModel;
    private $configModel;
    private $uploadModel;
    private $socialiteUserModel;
    private $passportClient;

    public function __construct(
      Request $request,
      User $userRepo,
      Config $configRepo,
      Upload $uploadRepo,
      SocialiteUser $socialiteUserRepo,
      PassportClient $passportClientRepo
    ) {
        $this->request = $request;
        $this->userModel = $userRepo;
        $this->configModel = $configRepo;
        $this->uploadModel = $uploadRepo;
        $this->socialiteUserModel = $socialiteUserRepo;
        $this->passportClient = $passportClientRepo;
    }
    /**
     * 将用户重定向到Provider认证页面
     *
     * @return Response
     */
    public function redirectToProvider($service, $redirect=null)
    {
        $this->request->session()->put('redirect', $redirect);//传入授权后的重定向加密网址 存入session
        return Socialite::driver($service)->redirect();
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
    public function scan($redirect=null)
    {
        // $this->request->session()->put('redirect', $redirect);//传入授权后的重定向加密网址 存入session
        // $builderAsset = resolve('builderAsset')->config('redirect', decrypt($redirect));
        // view()->share('resources', $builderAsset->response());//视图共享数据

        //缓存此次访问唯一id
        session(['uuid' => (string) Str::uuid()]);
        $QRcode = route('OAuth.scan.login') . DIRECTORY_SEPARATOR . session('uuid');
        return view('socialite::scanLogin', [ 'QRcode' => $QRcode ]);
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
    public function scanLogin($uuid)
    {
        event(new LoginBroadcasting($uuid));//登录成功广播事件
        $configs = $this->configModel->where('status', 1)->get();
        $socialite = $configs->mapWithKeys(function ($config) use ($uuid) {
            return [
                $config['service'] => route('OAuth.redirect', [
                    'service' => $config['service'],
                    'redirect' => encrypt(route('OAuth.scan.login').DIRECTORY_SEPARATOR.$uuid)
                ])
            ];
        })->toArray();
        return view('socialite::scanWapLogin', ['socialite' => $socialite]);
    }
    /**
     * [scanSuccess 付款成功回调]
     * @return   [type]         [description]
     * @Author   bigrocs
     * @QQ       532388887
     * @Email    bigrocs@qq.com
     * @DateTime 2018-03-12
     */
    public function scanSuccess()
    {
        if (Auth::id()) {
            $token = $this->passportClient->getPersonalAccessToken(Auth::id());
            $token['status_code'] = 200;
            $builderAsset = resolve('builderAsset')->config('toekn', $token);
            view()->share('resources', $builderAsset->response());//视图共享数据
        }
        return view('core::index', [ 'model' => 'socialite' ]);
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
            $user = $this->createUser($service, $socialiteUser);//创建用户
        } else {
            $user = $socialite->users;
        }
        Auth::login($user);
        return redirect($this->redirectUrl());//重定向
    }
    /**
     * 创建用户
     */
    private function createUser($service, $socialiteUser)
    {
        $user = Auth::user();//获取当前用户 如果没有用户注册新用户
        if (!$user) {
            $input = [
                'name' => $socialiteUser->name,
                'email' => $socialiteUser->email,
                'password' => str_random(10),//随机密码
                'nickname' => $socialiteUser->nickname,
            ];
            //方式用户名和邮箱已存在
            if ($this->userModel->findForUser($input['name'])) {
                $input['name'] = $service.'_'.$input['name'];
            }
            if ($this->userModel->findForUser($input['email'])) {
                $input['email'] = $service.'_'.$input['email'];
            }
            $user = $this->userModel->create($input);//创建用户
            //保存头像
            $imgName = $service.'_'.$socialiteUser->id;//保存头像名称
            $avatarId = $this->uploadModel->imageRemote($socialiteUser->avatar, $imgName, 'avatar')['uploadData']->id;
            $user->userInfos()->create(['avatar' => $avatarId]);//插入关联头像图片id
        }
        $socialite = $this->socialiteUserModel->where('user_id', $user->id)->first();
        if ($socialite) {
            //已绑定用户增加绑定新的第三方
            $update = $this->socialiteUserModel->where('user_id', $user->id)->update([$service => $socialiteUser->id]);
            return $update? $user: false;
        } else {
            // 关联用户
            $this->socialiteUserModel->$service = $socialiteUser->id;
            $this->socialiteUserModel->user_id  = $user->id;
            return $this->socialiteUserModel->save()? $user: false;
        }
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
