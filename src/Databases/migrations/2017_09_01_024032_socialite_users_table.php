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
            $table->integer('github')->comment('GitHub')->unsigned();
            $table->integer('facebook')->comment('Facebook')->unsigned();
            $table->integer('twitter')->comment('Twitter')->unsigned();
            $table->integer('linkedin')->comment('LinkedIn')->unsigned();
            $table->integer('qq')->comment('QQ')->unsigned();
            $table->integer('weixin')->comment('Weixin')->unsigned();
            $table->integer('weixinweb')->comment('WeixinWeb')->unsigned();
            $table->integer('weibo')->comment('Weibo')->unsigned();
            $table->integer('taobao')->comment('TaoBao')->unsigned();
            $table->integer('alipay')->comment('Alipay')->unsigned();
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
