<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationcontactemailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationcontactemail', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('station_id')->unsigned();
			$table->integer('contactemail_id')->unsigned();
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
        Schema::drop('stationcontactemail');
    }
}
