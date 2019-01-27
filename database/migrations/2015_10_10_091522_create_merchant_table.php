<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned()->unique();
			$table->string('company_name');

			/* gst holds the GST registration number */ 
			$table->string('gst')->nullable();
			$table->string('business_reg_no');
			$table->integer('country_id')->unsigned();
			$table->enum('business_type',array('sole_proprietorship',
				'partnership','sdn. bhd.','bhd.'))->nullable();

			/* merchant:director = 1:m */
			/* merchant:document = 1:m */
			/* merchant:website  = 1:m */

			$table->integer('address_id')->unsigned();

			/* Contact person is obsolete No UI exists.
			 * No update code ~Zurez*/ 
			$table->string('contact_person');
			$table->string('office_no');
			$table->string('mobile_no');

			/* Business function affecting OPOsum and PlatyPOS */
			/* This is obsolete. Bfunction has been moved to opos_terminal
			 * for terminal based allowing each terminal to have a different
			 * business function */
			
			// $table->enum('bfunction', ['spa','table','hotel','car','retail']);

			/* Business membership for dealers */
			$table->enum('membership', ['silver','gold','platinum']);

			$table->string('referral_code');


			/* Name and address of the O-Shop */
			$table->string('oshop_name');
			$table->integer('oshop_address_id')->unsigned();

			/* We support 5 logos for the O-Shop */
			$table->string('oshop_logo_1');
			$table->string('oshop_logo_2');
			$table->string('oshop_logo_3');
			$table->string('oshop_logo_4');
			$table->string('oshop_logo_5');

			/* These are images for O-Shop advertisment */
			$table->string('oshop_adimage_1');
			$table->string('oshop_adimage_2');
			$table->string('oshop_adimage_3');
			$table->string('oshop_adimage_4');
			$table->string('oshop_adimage_5');

			$table->text('description');
			$table->text('history');

			/* Custom O-Shop template is referred from:
			 * oshop_template table */
			$table->boolean('license')->default(false);
			
			$table->enum('coverage',array('klang_valley',
				'peninsula_malaysia','east_malaysia','export_only',
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

			/* Which merchant consultant brought this merchant in?
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
			$table->integer('order_administration_fee')->unsigned();
			$table->integer('annual_subscription_fee')->unsigned();

			/* The maximum number of products to be marketed under SMM.
			 * This value will be initialized from global */
			$table->smallinteger('smm_quota_max')->unsigned();

			/* The maximum number of post a SMM can make in 24 hrs */
			$table->smallinteger('smm_max_post')->unsigned();

			/* The minimum time in hours a SMM has to wait in between posts */
			$table->smallinteger('smm_min_duration')->unsigned();

			$table->text('return_policy');
			$table->integer('return_address_id')->unsigned();

			/* Commission table per merchant */
			$table->float('osmall_commission')->unsigned();

			/* Commission for B2B mode */
			$table->float('b2b_osmall_commission')->unsigned();
			
			$table->float('min_order')->unsigned();

			$table->float('mc_sales_staff_commission')->unsigned();
			$table->float('mc_with_ref_sales_staff_commission')->unsigned();
			$table->float('referral_sales_staff_commission')->unsigned();
			$table->float('mcp1_sales_staff_commission')->unsigned();
			$table->float('mcp2_sales_staff_commission')->unsigned();
			$table->float('smm_sales_staff_commission')->unsigned();

			/* Station Recruiter May not be needed in merchant */
			$table->float('str_sales_staff_commission')->unsigned();

			/* Pusher is now related to merchant with merchantsales_staff table
			 * due to 1:m or m:n relation */
			$table->float('psh_sales_staff_commission')->unsigned();

			/* Delivery */
			$table->boolean('all_system_delivery')->default(false);
			$table->boolean('all_own_delivery')->default(false);

			/* This records the logistic provider to be chosen when
			 * "Own Delivery" option is selected */
			$table->integer('own_delivery_logistic_id')->unsigned();

			/* Status */
			$table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected'))->default('pending');
			$table->timestamp('active_date');

			/*
				 Delivery Waiver Applied to Same Merchant amount in cent
				 if value set to 0 , then false.
			*/ 
			$table->integer('delivery_waiver_min_amt')->unsigned()->default(0);
			/* Note for merchant */
			$table->string('note');

 			/* Sequences for serial numbers */
			$table->integer('receipt_no')->unsigned();
			$table->integer('opossum_receipt_no')->unsigned();
			$table->integer('salesmemo_no')->unsigned();
			$table->integer('creditnote_no')->unsigned();
			$table->integer('debitnote_no')->unsigned();
			$table->integer('invoice_no')->unsigned();
			$table->integer('quotation_no')->unsigned();
			$table->integer('consignmentnote_no')->unsigned();
			$table->integer('salesorder_no')->unsigned();
			$table->integer('deliveryorder_no')->unsigned();
			$table->integer('pf_invoice_no')->unsigned(); //Pro-forma Invoice

			/* Subshipper ID for NinjaVan */
			$table->integer('nv_subshipper_id')->unsigned();
			$table->boolean('emailconfirm')->default(false);

			/* New Registration Wizard */
			$table->boolean('reg_wizard_complete')->default(false);

			/* Business Function for OPOSsum: default is retail,
			   no business buttons */
			$table->enum('bfunction', ['spa','table','hotel','car','retail'])->
				default('retail');

			/* Set a merchant-wide service charge.
			 * FK to opos_servicecharge table */
			$table->integer('servicecharge_id')->unsigned();

			/* Deprecated: DO NOT USE */
			$table->float('service_charge');

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
		Schema::drop('merchant');
	}

}
