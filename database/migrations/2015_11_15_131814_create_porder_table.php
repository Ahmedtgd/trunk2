<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePorderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('porder', function(Blueprint $table) {
			$table->increments('id')->unsigned();

			/* This is the BUYER */
			$table->integer('user_id')->unsigned();

			/* If the Buyer is from emerchant table, the above user_id will
			 * contain emerchant.id */
			$table->boolean('is_emerchant')->default(false);

			$table->integer('staff_user_id')->unsigned();

			/* The logistics provider for this order:
			 * This field is obsoleted and has been moved to table
			 * 'delivery' */
			//$table->integer('logistic_id')->unsigned();

			/* This is deprecated already: DON'T use this anymore */
			$table->integer('courier_id')->unsigned();

			/* Shipping address */
			$table->integer('address_id')->unsigned();

			/* porder:payment = 1:1  */
			$table->integer('payment_id')->unsigned();

			$table->integer('order_administration_fee')->unsigned();

			// $table->integer('delivery_administration_fee')->unsigned();
			// Delivery price we take from merchant
			// $table->integer('delivery_price')->unsigned();
			/* OBSOLETE: This is the station for the payment, pickup and
			 * collection of goods. This now related to by:
			 * sorder.station_id = station.id
			 * sorder.porder_id = porder.id */
			/*
			$table->integer('station_id')->unsigned();
			 */

			/*Commission percentages, for display purpose only*/ 
			$table->float('osmall_comm_percent')->default(0);
            $table->float('smm_comm_percent')->default(0);
            $table->float('ow_comm_percent')->default(0);
            $table->float('log_comm_percent')->default(0);

			/* Some description of this order */
			$table->string('description')->nullable();

			/* b2b: Station orders stock
			 * b2c: user buys from O-Shop
			 * ow: pledgers "buys" from social media post
			 * smm: social media users "buys" from SMM post
			 * hyper: users buys from Hyper pool
			 * spec: special products with price towards ONE individual only */
			$table->enum('source',
				array('b2c', 'b2b', 'ow', 'smm','hyper','spec','cre','mixed'))->
				default('b2c');

			/* Individual product may be cancelled or returned, status is 
			 * at table "orderproduct". Here is concerned on the entire
			 * product order */
			$table->enum('status', array('active','pending','hyper',
				'openwish','smm','manual','cancelreq','returnreq','undelivered',
				'processing','deliveryinprogress','complained','completed',
				'executed','cancelled','b-cancelled','m-cancelled',
				'returned', 'partial','delivered',
				'm-processing1','m-processing2','l-collected','b-collected',
				'b-returning','m-approved','b-returning','l-processing',
				'request-goods','call-logistic1','l-processing1',
				'l-collected1','m-collected','reviewed1','reviewed2',
				'commented','rejected1','rejected2',
				'returnaccepted','returnpartiallyaccepted','returnrejected'))->
				default('pending');

			/* The delivery mode of this porder */
			$table->enum('delivery_mode', ['system','own','pickup'])->
				default('own');

			/* To prevent buyer from requesting CRE for a porder multiple
			 * times. MAX VALUE IS 1*/
			$table->integer('cre_count')->default(0);
			
			/* Porder Mode */
			$table->enum('mode',
				['cash','term','vmi','jaguar','gator','invcost'])->
				default('cash');

			/* MRT Processing for retracing path for M-Approved:
			 * 1. B-Returning
			 * 2. M-Collected */
			$table->string('prev_m_approved');

			/* MRT Processing for retracing path for Completed:
			 * 1. Reviewed2
			 * 2. M-Approved
			 * 3. Reviewed1 */
			$table->string('prev_completed');

			/* Buyer checkouts: same as porder.created_at */
			$table->timestamp('checkout_tstamp');

			/* Goods dispatched for delivery: l-collected */
			$table->timestamp('delivery_tstamp');

			/* Receipt of goods by end-customer: b-collected */
			$table->timestamp('receipt_tstamp');

 			/* Completion of transaction: commented */
			$table->timestamp('completed_tstamp');
			
			$table->boolean('notification')->default(false);
 
			$table->softDeletes();

			/* Order received = created_at */
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
		Schema::drop('porder');
	}

}
