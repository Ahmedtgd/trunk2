<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourierTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courier', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('shipping_id');
			$table->string('name');
			$table->string('description');
			$table->string('progress_url');
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
		Schema::drop('courier');
	}

}
