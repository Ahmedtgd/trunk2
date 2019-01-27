<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapWorkingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_working', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('dayschedule_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('shift_id')->unsigned();
			$table->integer('position_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->engine = "MYISAM";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hcap_working');
    }
}
