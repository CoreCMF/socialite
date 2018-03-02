<?php
namespace CoreCMF\Socialite\App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LoginBroadcasting implements ShouldBroadcast
{
    use SerializesModels;

    public $uuid;
    public $laravelSession;

    /**
     * 创建一个新的事件实例.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
        $this->laravelSession = $_COOKIE['laravel_session'];
    }
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.Login.'.session('uuid'));
    }
}
