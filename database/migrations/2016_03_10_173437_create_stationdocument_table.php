<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStationdocumentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* This is to relate a merchant and his business documents */
		Schema::create('stationdocument', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('station_id')->unsigned();
			$table->integer('document_id')->unsigned();
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
		Schema::drop('stationdocument');
	}

}
