<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubshipperApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nv_create_subshipper_req', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nv_name');
			$table->string('nv_short_name');
			$table->string('nv_company_name');
			$table->string('nv_contact');
			$table->string('nv_prefix');
			$table->string('nv_liaison_name');
			$table->string('nv_liaison_contact');
			$table->string('nv_liaison_email');
			$table->string('nv_liaison_address');
			$table->string('nv_liaison_postcode');

			/* This is "returns_setting" for storing address for returns:
			 * "returns_settings": {
			 * 		"address_1": "30 Jalan Kilang Barat",
			 * 		"address_2": "Singapore",
			 * 		"city": "Singapore",
			 * 		"postcode": "159363",
			 * 		"name": "John Smith",
			 * 		"email": "returns@ninjavan.co"
			 * }, */
			$table->string('nv_rets_address_1');
			$table->string('nv_rets_address_2');
			$table->string('nv_rets_city');
			$table->string('nv_rets_postcode');
			$table->string('nv_rets_name');
			$table->string('nv_rets_email');

			/* This is "reservation_settings"
			 * "days": [                          
					1, // 1 - Sunday
					2, // 2 - Monday
					5,
					6,
					7 // 7 - Saturday
				], */
			$table->string('nv_rsrvs_days'); // CSV list of days: "1,2,5,6,7"


			/* This is "auto_reservation_settings":
			 * "auto_reservation_settings": {
			 * 		"enabled": true,
			 * 		"ready_time": "09:00:00",
			 * 		"latest_time": "18:00:00",
			 * 		"order_create_cutoff_time": "00:05:00",
			 * 		"address": {
			 * 	   		 "postcode": "159363",
			 * 	   		 "address1": "30 Jalan Kilang Barat (PICKUP)",
			 * 	   		 "address2": "Store #01-01",
			 * 	   		 "city": "SG",
			 * 	   		 "country": "SG",
			 * 	   		 "name": "ABC Warehouse IC",
			 * 	   		 "contact": "929605040",
			 * 	   		 "email": "warehouse@abc.com"
			 * 		}
			 * } */
			$table->string('nv_arsrvs_enabled');
			$table->string('nv_arsrvs_ready_time');
			$table->string('nv_arsrvs_latest_time');
			$table->string('nv_arsrvs_order_create_cutoff_time');
			$table->string('nv_arsrvs_enabled');
			$table->string('nv_arsrvs_postcode');
			$table->string('nv_arsrvs_address1');
			$table->string('nv_arsrvs_address2');
			$table->string('nv_arsrvs_city');
			$table->string('nv_arsrvs_country');
			$table->string('nv_arsrvs_name');
			$table->string('nv_arsrvs_contact');
			$table->string('nv_arsrvs_email');


			$table->softDeletes();
            $table->timestamps();
			$table->engine = "MYISAM";
        });

        Schema::create('nv_create_subshipper_resp', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nv_subshipper_id');
			$table->string('nv_name');
			$table->string('nv_email');
			$table->string('nv_prefix');
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
        Schema::drop('nv_create_subshipper_req');
        Schema::drop('nv_create_subshipper_resp');
    }
}
