<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableAdvertisement extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advertisement', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('slider')->unsigned();
			$table->integer('price')->unsigned();
			$table->integer('adslot_id')->unsigned();
			$table->string('url', 100);
			$table->string('name', 100);
			$table->string('phone', 15);
			$table->string('email', 50);
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
	public function down() {
		Schema::drop('advertisement');
	}
}
