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
            $table->integer('twitter')->comment('Twitter')      ->nullable()->unsigned();
            $table->integer('linkedin')->comment('LinkedIn')    ->nullable()->unsigned();
            $table->integer('qq')->comment('QQ')                ->nullable()->unsigned();
            $table->integer('weixin')->comment('Weixin')        ->nullable()->unsigned();
            $table->integer('weixinweb')->comment('WeixinWeb')  ->nullable()->unsigned();
            $table->integer('weibo')->comment('Weibo')          ->nullable()->unsigned();
            $table->integer('taobao')->comment('TaoBao')        ->nullable()->unsigned();
            $table->integer('alipay')->comment('Alipay')        ->nullable()->unsigned();
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
