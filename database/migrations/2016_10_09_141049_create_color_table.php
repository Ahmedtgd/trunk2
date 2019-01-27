<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateColorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('color', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->string('rgb');
			$table->string('hex');
			$table->softDeletes();
			$table->timestamps();
			$table->engine="MYISAM";
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('color');
	}

}
