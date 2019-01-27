<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description');

			/* Category logo in White foreground, Transparent background */
			$table->string('logo_white');
			/* Category logo in Green foreground, Transparent background */
			$table->string('logo_green');

			$table->smallinteger('floor')->unsigned();
			$table->smallinteger('original_floor')->unsigned();
			$table->string('color');
			$table->string('original_color');
			$table->boolean('enable')->default(true);
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
		Schema::drop('category');
	}

}
