<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-08-07 22:23:21
 */
use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateSocialiteAuthTable.
 */
class CreateSocialiteAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('socialite_auth', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->nullable()->comment('用户 ID');
            $table->string('identification')->nullable()->comment('标识');
            $table->string('type')->comment('登录类型');
            $table->string('state')->comment('状态码');
            $table->text('extra')->nullable()->comment('额外信息');
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
        $this->schema->drop('socialite_auth');
    }
}
