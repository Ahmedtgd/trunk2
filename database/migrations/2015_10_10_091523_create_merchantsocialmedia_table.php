<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantsocialmediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchantsocialmedia', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('merchant_id')->unsigned();
			$table->integer('smedia_id')->unsigned();
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
		Schema::drop('merchantsocialmedia');
	}

}
