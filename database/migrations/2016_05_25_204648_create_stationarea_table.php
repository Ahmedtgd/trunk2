<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('stationarea', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('area_id')->unsigned();
			$table->integer('station_id')->unsigned();
			$table->integer('amount')->unsigned();
			$table->timestamp('last_pick');

			$table->softDeletes()->nullable;
			$table->timestamps();

            $table->engine = 'MYISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stationarea');
    }
}
