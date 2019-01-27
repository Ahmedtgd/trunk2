<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('city', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->char('state_code',4);
			$table->char('country_code',3);
			$table->integer('citycountry_id')->unsigned();
			$table->integer('citystate_id')->unsigned();
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
		Schema::drop('city');
	}

}
