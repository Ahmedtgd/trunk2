<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirectorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('director', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			/* Merchant & Director relation -> merchantdirector pivot table */
			//$table->integer('merchant_id');

			/* Station & Director relation -> stationdirector pivot table */
			//$table->integer('station_id');

			$table->integer('country_id');
			$table->string('name');
			$table->string('nric');
			$table->string('photo_1');
			$table->string('photo_2');
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
		Schema::drop('director');
	}

}
