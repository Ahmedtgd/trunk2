<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNvOrderApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This is the storage of an actual outgoing Order to NinjaVan */
        Schema::create('nv_order_create_req', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('nv_from_postcode');
			$table->string('nv_from_address1');
			$table->string('nv_from_address2');
			$table->string('nv_from_locality');
			$table->string('nv_from_city');
			$table->string('nv_from_state');
			$table->string('nv_from_country');
			$table->string('nv_from_email');
			$table->string('nv_from_name');
			$table->string('nv_from_contact');
			$table->integer('nv_to_postcode');
			$table->string('nv_to_address1');
			$table->string('nv_to_address2');
			$table->string('nv_to_locality');
			$table->string('nv_to_city');
			$table->string('nv_to_state');
			$table->string('nv_to_country');
			$table->string('nv_to_email');
			$table->string('nv_to_name');
			$table->string('nv_to_contact');
			$table->date('nv_delivery_date');				// yyyy-mm-dd
			$table->date('nv_pickup_date');					// yyyy-mm-dd
			$table->string('nv_pickup_weekend');			// true || false
			$table->string('nv_delivery_weekend');			// true || false
			$table->string('nv_staging');					// true || false
			$table->integer('nv_pickup_timewindow_id');		// -3,,0,.3
			$table->integer('nv_delivery_timewindow_id');	// -3,,0,.3
			$table->integer('nv_max_delivery_days');
			$table->integer('nv_cod_goods');
			$table->string('nv_pickup_instruction');
			$table->string('nv_delivery_instruction');
			$table->string('nv_requested_tracking_id');
			$table->string('nv_order_ref_no');
			$table->enum('nv_type',
				['NORMAL','RETURN','C2C'])->default('NORMAL');
			$table->integer('nv_parcel_volume');
			$table->integer('nv_parcel_size');
			$table->integer('nv_parcel_new_size');
			$table->float('nv_parcel_weight');
			$table->float('nv_parcel_new_weight');
			$table->string('nv_seller_id');
            $table->softDeletes();
            $table->timestamps();
            $table->engine = "MYISAM";
        });

		/* The response to an nv_order_create_req message */
        Schema::create('nv_order_create_resp', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nv_order_id');
			$table->string('nv_status');
			$table->string('nv_message');
			$table->string('nv_order_ref_no');
			$table->string('nv_tracking_id');

			/* Below 4 columns to be updated via Webhook */
			$table->string('nv_new_weight');
			$table->string('nv_previous_weight');
			$table->string('nv_new_size');
			$table->string('nv_previous_size'); 
            $table->softDeletes();
            $table->timestamps();
            $table->engine = "MYISAM";
        }); 

		/* A nv_order_search_req will be responded by a nv_create_order_req */
        Schema::create('nv_order_search_req', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nv_order_ref_no');
			$table->string('nv_requested_tracking_id');
			$table->string('nv_tracking_id');
			$table->string('nv_order_id');
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
        Schema::drop('nv_order_create_req');
        Schema::drop('nv_order_create_resp');
        Schema::drop('nv_order_search_req');
    }
}
