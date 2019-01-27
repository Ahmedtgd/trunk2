<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStationbrandTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stationbrand', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('station_id');
			$table->integer('brand_id');
			$table->integer('subcat_id')->unsigned();
			$table->integer('subcat_level')->unsigned();
 			/* This is how the merchant relates to the brand; i.e. is
			 * he the manufacturer, main distributor, distributor,
			 * sub-distributor or just a retailer? */
			$table->enum('relationship', ['Manufacturer','Main Distributor','Distributor','Sub-Distributor','Retailer'])->default('Manufacturer');			
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
		Schema::drop('stationbrand');
	}

}
