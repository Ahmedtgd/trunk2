<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNstationidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nstationid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('nstation_id')->unique();
			$table->integer('user_id')->unsigned();
			$table->integer('station_id')->unsigned();
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
        Schema::drop('nstationid');
    }
}
