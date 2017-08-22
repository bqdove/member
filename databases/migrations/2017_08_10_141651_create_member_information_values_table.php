<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-08-10 14:16:51
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateMemberInformationValuesTable.
 */
class CreateMemberInformationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_information_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->comment('用户 ID');
            $table->integer('information_id')->comment('信息项 ID');
            $table->text('value')->nullable()->comment('信息值');
            $table->softDeletes();
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
        $this->schema->drop('member_information_values');
    }
}
