<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugin_account', function (Blueprint $table) {
            $table->increments('account_id');
            $table->string('account')->default('')->comment('账号');
            $table->string('password')->default('')->comment('密码');
            $table->tinyInteger('state')->default('0')->nullable()->comment('状态{0:禁用,1:正常}');
            $table->tinyInteger('script_state')->default('0')->nullable()->comment('脚本状态{0:未登录,1:登录未使用,2:开挂中}');
            $table->tinyInteger('game_state')->nullable()->comment('游戏状态{0:正常,1:异常}');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugin_account');
    }
}
