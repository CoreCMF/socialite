<?php

namespace CoreCMF\Socialite\App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'socialite_users';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(\CoreCMF\Core\App\Models\User::class,'user_id');
    }
}
