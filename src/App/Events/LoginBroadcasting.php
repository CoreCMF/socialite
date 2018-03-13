<?php
namespace CoreCMF\Socialite\App\Events;

use Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use CoreCMF\Core\App\Models\PassportClient;

class LoginBroadcasting implements ShouldBroadcast
{
    use SerializesModels;

    public $uuid;
    public $token;
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
        if ($this->state) {
            $this->token = $this->getToken();
        }
    }
    public function broadcastOn()
    {
        return new Channel('App.User.Login.'.$this->uuid);
    }
    private function getToken()
    {
        $passportClient = new passportClient();
        $token = $passportClient->getPersonalAccessToken(Auth::id());
        $token['status_code'] = 200;
        return $token;
    }
}
