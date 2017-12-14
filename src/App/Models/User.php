<?php

namespace CoreCMF\Socialite\App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'socialite_users';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(\CoreCMF\Core\App\Models\User::class, 'user_id');
    }
    /**
     * [getSocialiteId 根据驱动获取当前用户唯一ID]
     * @param    [type]         $userId  [description]
     * @param    [type]         $service [description]
     * @return   [type]                  [description]
     * @Author   bigrocs
     * @QQ       532388887
     * @Email    bigrocs@qq.com
     * @DateTime 2017-12-14
     */
    public function getSocialiteId($userId, $service)
    {
        return $this->where('user_id', $userId)->first()->$service;
    }
}
