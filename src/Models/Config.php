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
}
