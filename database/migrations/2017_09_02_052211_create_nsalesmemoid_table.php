<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNsalesmemoidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nsalesmemoid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('nsalesmemo_id')->unique();
			$table->integer('salesmemo_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
			$table->engine = "MyISAM";
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nsalesmemoid');
    }
}
