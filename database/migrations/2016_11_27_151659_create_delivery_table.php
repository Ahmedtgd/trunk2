<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
       Schema::create('delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('delivered_date');
            $table->integer('porder_id')->unsigned();
            // $table->integer('merchant_id')->unsigned();

            $table->integer('logistic_id')->unsigned();
			$table->enum('status',[
				'active','pending','inprogress','delivered',
				 'pickup_successful','pickup_failed','delivery_failed',
				 'dfailed1','dfailed2','dfailed3','return_to_sender'
			 ])->default('active');

            $table->string('consignment_number');
			$table->string('receipient_city');

            // Added on 17th Jan 2017
            $table->integer('package_count')->unsigned();
            $table->integer('packagedimension_id')->unsigned();
			$table->string('sender_city');
            $table->integer('delivery_administration_fee')->unsigned();

			// ** This is obsolete: FK -> dfailure **
			/* Counter to count delivery attempts */
			/*
            $table->integer('attempt')->unsigned()->default(0);
            $table->timestamp('failure_timestamp');
            $table->string('failure_comment');
			*/

			// $table->string('image');
			// $table->string('details');
            /*
                b2m -> buyer to merchant, e.g. return
                m2b -> merchant to buyer  
                m2m -> merchant to merchant,  e.g. b2b
            */ 
            $table->enum('type',['b2m','m2b','m2m']);
			$table->string('pickup_password');
			$table->string('pickup_name')->nullable();
			$table->string('pickup_nric')->nullable();

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
    public function down() {
        Schema::drop('delivery');
    }

}
