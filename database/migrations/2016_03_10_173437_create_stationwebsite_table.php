<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStationwebsiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stationwebsite', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('station_id')->unsigned();	
			$table->integer('website_id')->unsigned();
			$table->softDeletes();
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
		Schema::drop('stationwebsite');
	}

}
