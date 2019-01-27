<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantcategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchantcategory', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('merchant_id');
			$table->integer('category_id');
			$table->softDeletes();
			$table->timestamps();

			// To prevent duplication of merchant records
			$table->index(['merchant_id', 'category_id']);

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
		Schema::drop('merchantcategory');
	}

}
