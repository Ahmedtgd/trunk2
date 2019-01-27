<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantwebsiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchantwebsite', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('merchant_id')->unsigned();	
			$table->integer('website_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();

			$table->engine = 'MYISAM';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return 
	 */
	public function down()
	{
		Schema::drop('merchantwebsite');
	}

}
