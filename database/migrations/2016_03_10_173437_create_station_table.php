<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->unique();
            $table->string('company_name');
            $table->string('gst')->nullable();
            $table->string('business_reg_no');
            $table->integer('country_id')->unsigned();
			$table->enum('business_type',array('sole_proprietorship',
				'partnership','sdn. bhd.','bhd.'))->nullable();

			/* Business Owner of the station */
            $table->string('contact_person');
            $table->string('office_no');
            $table->string('mobile_no');
            $table->integer('address_id')->unsigned();

            /* Business Name and address of the Station */
            $table->string('station_name');
            $table->string('station_description');
            $table->integer('station_address_id')->unsigned()->nullable();

			/* More information about the station */
            $table->text('description');
            $table->text('history');

			/**** This is now in sproperty, where:
			 * station:sproperty = 1:m, as a station can have many outlets
			 */
			/* Area of the shop in sq.ft. */
            //$table->integer('shop_size')->unsigned()->nullable();

			/* Property Owner of the station */
            //$table->string('property_owner');
            //$table->string('prop_owner_mobile');

            $table->boolean('license')->default(false);
			$table->enum('coverage',array('klang_valley',
				'peninsula_malaysia','east_malaysia',
				'international'))->nullable();
            $table->boolean('ownership')->default(false);
            $table->integer('category_id')->unsigned();
            $table->integer('planned_sales')->unsigned();

            $table->integer('bankaccount_id')->unsigned();

            /* This is the switch for OpenSupermall's commission type */
            $table->enum('commission_type',
                array('std','var'))->default('std');            
			
			$table->enum('b2b_commission_type',
                array('std','var'))->default('std');
    
            /* Which merchant consultant brought this station in?
             * Table sales_staff is a general store for commissionable
             * sales staff */
            $table->integer('mc_sales_staff_id')->unsigned();

            /* This merchant maybe an internal referral from another 
             * merchant consultant from another region or country.
             * We keep track of the referral source too. */
            $table->integer('referral_sales_staff_id')->unsigned();

            $table->integer('mcp1_sales_staff_id')->unsigned();
            $table->integer('mcp2_sales_staff_id')->unsigned();
            $table->integer('psh_sales_staff_id')->unsigned();
            $table->integer('str_sales_staff_id')->unsigned();

			$table->integer('order_administration_fee')->unsigned();
			$table->integer('annual_subscription_fee')->unsigned();
            /* The maximum number of products to be marketed under SMM.
             * This value will be initialized from global */
            $table->smallinteger('smm_quota_max')->unsigned();

            /* The maximum number of post a SMM can make in 24 hrs */
            $table->smallinteger('smm_max_post')->unsigned();

            /* The minimum time in hours a SMM has to wait in between posts */
            $table->smallinteger('smm_min_duration')->unsigned();

            $table->text('return_policy')->nullable();

            /* Commission table per station */
            $table->float('osmall_commission')->unsigned();

			/* Commission for B2B mode */
            $table->float('b2b_osmall_commission')->unsigned();

            $table->float('mc_sales_staff_commission')->unsigned();
            $table->float('mc_with_ref_sales_staff_commission')->unsigned();
            $table->float('referral_sales_staff_commission')->unsigned();
            $table->float('mcp1_sales_staff_commission')->unsigned();
            $table->float('mcp2_sales_staff_commission')->unsigned();
            $table->float('smm_sales_staff_commission')->unsigned();
            $table->float('str_sales_staff_commission')->unsigned();

			/* May not be needing Pushers for station.. */
            $table->float('psh_sales_staff_commission')->unsigned();

            /* Status */
            $table->enum('status', array('pending','active','dormant',
                'barred','suspended','rejected'))->default('pending');
            $table->timestamp('active_date');

			/* Note for station */
			$table->string('note');

			/* Sequences for serial numbers */
			$table->integer('receipt_no')->unsigned();
			$table->integer('invoice_no')->unsigned();
			$table->integer('pf_invoice_no')->unsigned(); // Pro-forma Invoice

			/* Station industry: For different industries of stations
			 * This is OBSOLETED. Use stationtype for differentiating
			 * types of stations 
			$table->enum('industry', ['logistic','carpark','cafedining',
				'shopping'])->default('shopping');
			 */

			/* Station type: For different industries of stations */
			$table->integer('stationtype_id')->unsigned()->default(1);

			/* Station character: Either consumer or network */
			$table->enum('scharacter',
				['network','consumer'])->default('network');

 			/* Delivery capability of a station */
			$table->enum('delivery_mode', array('pickup','pickup;sys_delivery',
				'pickup;own_delivery'))->default('pickup;sys_delivery');

			/* OBSOLETED because station:term = 1:m, Term feature
			$table->integer('term')->unsigned()->default(0); //in days
			$table->integer('credit_limit')->unsigned()->default(0); //in cents
			 */

 			/* Subshipper ID for NinjaVan */
			$table->integer('nv_subshipper_id')->unsigned();
			
			$table->boolean('emailconfirm')->default(false);

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
        Schema::drop('station');
    }
}
