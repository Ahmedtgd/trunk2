<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebsiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('website', function(Blueprint $table) {
			$table->increments('id')->unsigned();

			/* This is the name of the site: Facebook, Mudah.com, etc. */
			$table->string('name');
			$table->string('description');
			$table->string('url');

			/* This is the type of site */
			$table->enum('type', array('website','socialmedia','ecommerce'));
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
		Schema::drop('website');
	}

}
