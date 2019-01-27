<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('brand', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name')->unique();
			$table->string('description');
			$table->string('logo');

			/* Note that this brand can have many types of product categories,
			 * or rather, product subcategories */
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
		Schema::drop('brand');
	}

}
