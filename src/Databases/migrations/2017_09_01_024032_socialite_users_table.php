<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SocialiteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialite_users', function (Blueprint $table) {
            $table->increments('user_id')->unsigned();
            $table->integer('github')->comment('GitHub')        ->nullable()->unsigned();
            $table->integer('facebook')->comment('Facebook')    ->nullable()->unsigned();
            $table->integer('google')->comment('Google')       ->nullable()->unsigned();
            $table->integer('linkedin')->comment('LinkedIn')    ->nullable()->unsigned();
            $table->integer('twitter')->comment('Twitter')      ->nullable()->unsigned();
            $table->integer('qq')->comment('QQ')                ->nullable()->unsigned();
            $table->integer('wechat')->comment('微信')          ->nullable()->unsigned();
            $table->integer('wechatweb')->comment('微信WEB')    ->nullable()->unsigned();
            $table->integer('weibo')->comment('微博')           ->nullable()->unsigned();
            $table->integer('renren')->comment('人人')          ->nullable()->unsigned();
            $table->integer('douban')->comment('豆瓣')          ->nullable()->unsigned();
            $table->integer('baidu')->comment('百度')           ->nullable()->unsigned();
            $table->integer('taobao')->comment('淘宝')          ->nullable()->unsigned();
            $table->integer('alipay')->comment('支付宝')        ->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('core_users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socialite_users');
    }
}
