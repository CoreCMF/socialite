<?php
namespace CoreCMF\Socialite\App\Events;

use Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LoginBroadcasting implements ShouldBroadcast
{
    use SerializesModels;

    public $uuid;
    public $cookies;
    public $state;

    /**
     * 创建一个新的事件实例.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
        $this->state = Auth::id()? 1 : 0;
        // if ($this->state) {
        //     $this->cookies['laravel_token'] = $_COOKIE['laravel_token'];
        //     $this->cookies['laravel_session'] = $_COOKIE['laravel_session'];
        // }
    }
    public function broadcastOn()
    {
        return new Channel('App.User.Login.'.$this->uuid);
    }
}
