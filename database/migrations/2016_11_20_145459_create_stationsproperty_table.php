<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationspropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationsproperty', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('station_id')->unsigned();
			$table->integer('sproperty_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('stationsproperty');
    }
}
