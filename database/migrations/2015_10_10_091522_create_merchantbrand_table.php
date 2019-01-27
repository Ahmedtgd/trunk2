<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantbrandTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchantbrand', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('merchant_id')->unsigned();
			$table->integer('brand_id')->unsigned();
			$table->integer('subcat_id')->unsigned();
			$table->integer('subcat_level')->unsigned();

 			/* This is how the merchant relates to the brand; i.e. is
			 * he the manufacturer, main distributor, distributor,
			 * sub-distributor or just a retailer? */
			$table->enum('relationship', ['Manufacturer','Main Distributor',
				'Distributor','Sub-Distributor','Retailer'])->
				default('Manufacturer');

			$table->boolean('official_distributorship')->default('false');
 
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
		Schema::drop('merchantbrand');
	}

}
