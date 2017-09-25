<?php
namespace CoreCMF\Socialite\Databases\seeds;

use DB;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('socialite_configs')->insert([
            'name' => '微信',
            'service' => 'wechat',
            'redirect'=> route('OAuth.callback',['service' => 'wechat']),
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'QQ',
            'service' => 'qq',
            'redirect'=> route('OAuth.callback',['service' => 'qq']),
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '微信WEB',
            'service' => 'wechatweb',
            'redirect'=> route('OAuth.callback',['service' => 'wechatweb']),
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '微博',
            'service' => 'weibo',
            'redirect'=> route('OAuth.callback',['service' => 'weibo']),
        ]);
        // DB::table('socialite_configs')->insert([
        //     'name' => '人人',
        //     'service' => 'renren',
        //     'redirect'=> route('OAuth.callback',['service' => 'renren']),
        // ]);
        DB::table('socialite_configs')->insert([
            'name' => '豆瓣',
            'service' => 'douban',
            'redirect'=> route('OAuth.callback',['service' => 'douban']),
        ]);
        // DB::table('socialite_configs')->insert([
        //     'name' => '百度',
        //     'service' => 'baidu',
        //     'redirect'=> route('OAuth.callback',['service' => 'baidu']),
        // ]);
        // DB::table('socialite_configs')->insert([
        //     'name' => '支付宝',
        //     'service' => 'alipay',
        //     'redirect'=> route('OAuth.callback',['service' => 'alipay']),
        // ]);
        // DB::table('socialite_configs')->insert([
        //     'name' => '淘宝',
        //     'service' => 'taobao',
        //     'redirect'=> route('OAuth.callback',['service' => 'taobao']),
        // ]);
        DB::table('socialite_configs')->insert([
            'name' => 'GitHub',
            'service' => 'github',
            'redirect'=> route('OAuth.callback',['service' => 'github']),
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'FaceBook',
            'service' => 'facebook',

            'redirect'=> route('OAuth.callback',['service' => 'facebook']),
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'Google',
            'service' => 'google',
            'redirect'=> route('OAuth.callback',['service' => 'google']),
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'Linkedin',
            'service' => 'linkedin',
            'redirect'=> route('OAuth.callback',['service' => 'linkedin']),
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'Twitter',
            'service' => 'twitter',
            'redirect'=> route('OAuth.callback',['service' => 'twitter']),
        ]);
    }
}
