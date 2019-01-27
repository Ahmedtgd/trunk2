<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductcolorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productcolor', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('product_id')->unsigned();	
			$table->integer('color_id')->unsigned();	
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
		Schema::drop('productcolor');
	}

}
