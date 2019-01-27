<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cart', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('parent_id')->unsigned();
			$table->integer('hyper_id')->unsigned();
			$table->integer('openwish_id')->unsigned();
			$table->integer('smmin_id')->unsigned();
			$table->integer('price');
			$table->string('unique_identifier')->unique();
			$table->string('product_name');
			$table->string('identifier');
			$table->float('delivery_price');
			$table->float('actual_delivery_price');
			$table->integer('quantity')->unsigned();
			$table->integer('tokenquantity')->unsigned();
			$table->string('image');
			$table->float('gst');
			$table->string('page');
			$table->string('mode');
			$table->integer('merchant_id')->unsigned();
			$table->string('oshop_name');
			$table->string('company_name');
			$table->enum('status',['active','destroyed']);
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
		Schema::drop('cart');
	}

}
