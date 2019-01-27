<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryorder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deliveryorder_no')->unsigned();
            $table->integer('receipt_id')->unsigned();

			/* This is typically the delivery person */
            $table->integer('member_id')->unsigned();

			/* The merchant whom an imported DO belongs to. 
			 * Only if we are unable to create a porder for the imported DO */
            $table->integer('merchant_id')->unsigned();

            $table->integer('initial_location_id')->unsigned();
            $table->integer('final_location_id')->unsigned();

			$table->enum('status', array('confirmed','delivered','undelivered',
				'partial', 'pending','converted_tr','discarded','inprogress',
				'cancelled','pickup','completed'))->default('pending');

			$table->enum('source', ['imported','gator','jaguar','ecommerce']);

			$table->enum('action', ['issue','tr','discard']);

			$table->enum('discard', ['pickup','cancelled','error']);

            $table->softDeletes();
            $table->timestamps();
            $table->engine = "MYISAM";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deliveryorder');
    }
}
