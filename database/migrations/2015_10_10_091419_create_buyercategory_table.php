<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuyercategoryTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('buyercategory', function (Blueprint $table) {
			$table->increments('id')->unsigned();

			/* A buyer is a valid user too */
			$table->integer('user_id')->unsigned();

			/* These are all the categories which this buyer is interested in */
			$table->integer('subcat_id')->unsigned();
			$table->integer('subcat_level')->unsigned();

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
		Schema::drop('buyercategory');
	}

}
