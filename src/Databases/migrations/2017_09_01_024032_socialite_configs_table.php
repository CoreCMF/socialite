<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SocialiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialite_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service')        ->comment('驱动名称')->unique() ->unsigned();
            $table->integer('client_id')      ->comment('客户ID') ->nullable()->unsigned();
            $table->integer('client_secret')  ->comment('客户密钥')->nullable()->unsigned();
            $table->integer('redirect')       ->comment('回调地址')->nullable()->unsigned();
            $table->tinyInteger('status')     ->comment('状态')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socialite_configs');
    }
}
