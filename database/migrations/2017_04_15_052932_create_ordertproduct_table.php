<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdertproductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ordertproduct', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('porder_id')->unsigned();
			$table->integer('tproduct_id')->unsigned();

			/* This is the order price, which may be difference from retail
			 * price due to wholesale tiered pricing, over special
			 * individual pricing */
			$table->integer('order_price')->unsigned();

			// The amount taken from Buyer. Could be 0
			$table->integer('order_delivery_price')->unsigned();
			$table->integer('payment_gateway_fee')->unsigned();
			$table->integer('quantity')->unsigned();

			// The amount that was supposed to be charged!Shown to merchant
			$table->integer('actual_delivery_price')->unsigned();

			// Payable to Logistic
			$table->integer('shipping_cost')->unsigned();

			/* For return if returning more than single product,
			 * each product might have different reason for return */
			$table->integer('crereason_id')->unsigned()->nullable();

			//In cents 
            $table->integer('osmall_comm_amount')->unsigned()->default(0);
            $table->integer('smm_comm_amount')->unsigned()->default(0);
            $table->integer('ow_comm_amount')->unsigned()->default(0);

 			/* b2b: Station orders stock
			 * b2c: user buys from O-Shop
			 * ow: pledgers "buys" from social media post
			 * smm: social media users "buys" from SMM post
			 * hyper: users buys from Hyper pool
			 * spec: special products with price towards ONE individual only */
			$table->enum('source',
				array('b2c', 'b2b', 'ow', 'smm','hyper','spec','cre'))->
				default('b2b');
 
			/* This is the status of the individual product within an order,
			 * which may be cancelled or returned */
			$table->enum('status', array('delivered','undelivered',
				'pending','cancelreq','cancelled','returnreq',
				'returned','executed','rejected',
				'm-processing1','m-processing2','l-collected','b-collected',
				'b-returning1','m-approved1','b-returning2','l-processing',
				'l-accepted','m-collected','m-approved2','reviewed',
				'commented','returnaccepted','completed','returnrejected',
				'b-paid1','l-processing2'
			))->default('pending');

			/* Has OpenSupermall paid commission to the agent? */
			$table->float('commission_paid')->default(false);

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
		Schema::drop('ordertproduct');
	}
}
