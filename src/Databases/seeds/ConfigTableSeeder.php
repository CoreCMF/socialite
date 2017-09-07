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
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'QQ',
            'service' => 'qq',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '微信WEB',
            'service' => 'wechatweb',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '微博',
            'service' => 'weibo',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '人人',
            'service' => 'renren',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '豆瓣',
            'service' => 'douban',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '百度',
            'service' => 'baidu',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '支付宝',
            'service' => 'alipay',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => '淘宝',
            'service' => 'taobao',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'GitHub',
            'service' => 'github',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'FaceBook',
            'service' => 'facebook',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'Google',
            'service' => 'google',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'Linkedin',
            'service' => 'linkedin',
        ]);
        DB::table('socialite_configs')->insert([
            'name' => 'Twitter',
            'service' => 'twitter',
        ]);
    }
}
