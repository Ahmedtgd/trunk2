<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpenwishTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* Definition of a OpenWish record.
		 * Individual contribution towards this is stored in 
		 * openwishPledge */

		/* OpenWish:OpenWishPledge = 1:m */

		Schema::create('openwish', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();	
			$table->integer('product_id')->unsigned();	

			/* The final order for the completed pledge */
			$table->integer('porder_id')->unsigned();	

			/* To store and track the FB link-id */
			$table->string('link_id');
			/*Price Locks*/
			$table->integer('price');
			$table->integer('delivery_price'); 
			/* Duration of this OpenWish: in days */
			$table->integer('duration')->unsigned();	
			/*Openwish shared count*/
			$table->integer('shared_count')->unsigned(); 
			/* Status of an OpenWish */
			$table->enum('status',
				array('executed','delivered','expired', 'active','pending'))
				->default('pending');

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
		Schema::drop('openwish');
	}

}
