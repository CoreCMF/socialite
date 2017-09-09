<?php

namespace CoreCMF\Socialite\Models;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $table = 'socialite_configs';

    protected $fillable = ['service', 'client_id', 'client_secret', 'redirect'];

    public function getStatusAttribute($value)
    {
        return (boolean)$value;
    }
    /**
     * [configRegister 第三方社会登录配置信息写入config]
     * @return [type] [description]
     */
    public function configRegister()
    {
        $this->where('status', 1)->get()->map(function($item){
            config(['services.'.$item->service => [
                'client_id' => $item->client_id,
                'client_secret' => $item->client_secret,
                'redirect' => $item->redirect
              ]]);
        });
    }
}
