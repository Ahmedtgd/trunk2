<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

	/* This contains all global variables in the system, typically only
	 * accessible by admin or superuser. Some of these variables are
	 * overrideable in the individual tables; e.g. smm_selection_max
	 *To prevenet duplicacy please add the newest entry at the bottom
	  */

    public function up()
    {
        Schema::create('global', function (Blueprint $table) {
            $table->increments('id');

			/* Default delivery time, in days */
			$table->integer('delivery_sop')->unsigned()->default(3);

			/* Admin fee for each delivery, in MYR.
			 * Note that this follows standard storage in cents */
			$table->integer('delivery_administration_fee')->
				unsigned()->default(100);

			/* Admin fee for each order, in MYR.
			 * Note that this follows standard storage in cents */
			$table->integer('order_administration_fee')->
				unsigned()->default(200);

			/* The maximum number of products a merchant can select for 
			 * SMM marketing: should be tweakable for individual merchants */
            $table->integer('smm_quota_max')->unsigned()->default(10000);

            /* The maximum number of post a SMM can make in a single day */
            $table->smallinteger('smm_max_post')->unsigned()->default(20);

            /* The minimum time in hours a SMM has to wait in between post */
            $table->smallinteger('smm_min_duration')->unsigned()->default(1);

			/* The maximum time a SMM post will survive out there in the 
			 * Internet, taking into multiple retweets, shares, etc.
			 * Defaults to 30 days */
			$table->smallinteger('smm_active_duration')->
				unsigned()->default(30);

			/* SMM new commission formula update ~Zurez
			 * SMM commission in percentage */
			$table->float('smm_commission')->unsigned()->default(2);

			/* SMM Minimum Commission Limit in cents */
			$table->smallinteger('smm_min_limit')->unsigned()->default(1);

			/* The number of days for a owarehouse duration where a product 
			 * can wait for pledges: invididual merchants has the facility
			 string to override this */
			$table->smallinteger('owarehouse_duration')->
				unsigned()->default(30);

			/* iPay88 Merchant Credentials */
			$table->char('ipay88_merchant_code', 6)->default('M07836');
			$table->char('ipay88_merchant_key', 10)->default('pJqOVIbRfL');
			/* Global iPay88 commission in percentage */
			$table->float('payment_gateway_commission')->default(3);

			/* FPX Payment Gateway: UAT */
			$table->string('fpx_seller_id')->default('SE00007140');
			$table->string('fpx_exchange_id')->default('EX00006111');
			$table->string('fpx_uat_url')->default(
				'https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp');
			$table->string('fpx_uat_be_url')->default(
				'https://uat.mepsfpx.com.my/FPXMain/RetrieveBankList');
			$table->string('fpx_uat_ae_url')->default(
				'https://uat.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp');

			/* FPX Payment Gateway: PRD */
			$table->string('fpx_prd_seller_id')->default('SE00028102');
			$table->string('fpx_prd_exchange_id')->default('EX00007483');
			$table->string('fpx_prd_url')->default(
				'https://www.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp');
			$table->string('fpx_prd_be_url')->default(
				'https://www.mepsfpx.com.my/FPXMain/RetrieveBankList');
			$table->string('fpx_prd_ae_url')->default(
				'https://www.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp');
			/* Global FPX commission in percentage:
			 * B2C: MYR1.00 + 1%
			 * B2B: MYR2.50 + 1% */
			$table->float('fpx_commission_b2c')->default(1.0);
			$table->integer('fpx_commission_b2c_fixed')->default(100);
			$table->float('fpx_commission_b2b')->default(1.0);
			$table->integer('fpx_commission_b2b_fixed')->default(250);

			/* JomPay commission */
			$table->integer('jpay_commission_fixed')->default(150);
			$table->float('jpay_commission_ccard')->default(1.0);
			$table->integer('jpay_commission_ccard_fixed')->default(150);
			$table->integer('jpay_real_time_notification')->default(5);

			/* OCBC Visa/Mastercard commission (all in percentages) */
			$table->float('ocbc_mdr_creditcard')->default(1.59);
			$table->float('ocbc_mdr_debitcard')->default(0.848);
			$table->float('ocbc_mdr_prepaidcard')->default(0.848);


			/* CityLink API Credentials */
			$table->string('ctl_companycode')->default('CT');
			$table->string('ctl_account')->default('00163167');
			$table->string('ctl_meternumber')->default('TEST 123');
			

			/* CityLink Pickup Emails */
			$table->string('ctl_pickup_email1')
				->default('masaini.com@citylinkexpress.com.my');
			$table->string('ctl_pickup_email2')
				->default('pickup@citylinkexpress.com.my');
			$table->string('ctl_origin_station')->default('CRS');

			/* City Link Surcharges*/ 
			$table->float('ctl_surcharge')->default(36.0);
			
			/* NinjaVan API */
			$table->string('nv_webhook_log')->default('/home/osmall/log/nv_webhook.log');

			/* NinjaVan: Staging & Testing Environment */
			$table->string('nv_client_id')->default('3e6a0d9471a74e1689bdaaa316dde41f');
			$table->string('nv_client_secret')->default('1d18fbc3c0a4479d86cf735a00241a17');
			$table->string('nv_base_uri')->default('https://api-sandbox.ninjavan.co/sg');

			/* NinjaVan: Production & Live Environment */
			$table->string('nv_prd_client_id')->default('a07c0e78aa8949149d43542527df5ecf');
			$table->string('nv_prd_client_secret')->default('b6657c33e496496086d4388a6aec74ac');
			$table->string('nv_prd_base_uri')->default('https://api.ninjavan.co/my');

			$table->string('nv_auth_api')->default('/2.0/oauth/access_token');
			//$table->string('nv_subshipper_api')->default('/1.0/shippers/sub-shippers');
			$table->string('nv_order_api')->default('/4.0/orders');
			//$table->string('nv_ms_order_api')->default('/3.0/shippers/{{shipper_id}}/orders');
			$table->string('nv_search_api')->default('/4.0/orders/{{tracking_id}}');
			$table->string('nv_cancel_api')->default('/4.0/orders/{{tracking_id}}/cancel');
			$table->string('nv_track_api')->default('/2.0/track');
			
			/* Ninja Van Pickup Emails */
			$table->string('nv_pickup_email1')
				->default('admin@ninjavan.co');
			
			/* Ninja Van Surcharges*/ 
			$table->float('nv_surcharge')->default(0.0);

			/* GST Goods & Services Tax in percentage */
			$table->float('gst_rate')->default(6.0);

            /* Default volumetric factor for Logistic providers */
			$table->integer('volfactor')->unsigned()->default(5000);

			/* Maximum size of uploaded video clip in MB.
			 * Used in vbanner, may not be relevant currently */
			$table->integer('max_video_size')->default(1);

			/* Maximum size of uploaded image. Used in productdetail.data
			 * via Summernote's image upload interface */ 
			$table->integer('max_img_size')->default(10);

			/* J&C Production ARS Server URL */
			$table->string('jc_ars_url')->
				default('http://168.63.241.234:7001/ARS_TP');

			/* Time window for a buyer to be able to cancel his order in
			 * order to get a refund. This in MINUTES */
			$table->integer('buyer_cancellation_window')->
				unsigned()->default(60);

			/* Time window for a merchant/station to process a sales order
			 * before a network station goes to the next rotation, or a
			 * merchant to be escalated for investigation in HOURS */
			$table->integer('merchant_process_salesorder_window')->
				unsigned()->default(24);

			/* For merchant timer, in HOURs */ 
			$table->integer('merchant_process_return_window')->
				unsigned()->default(24);

			/* Time window for a buyer to be able to RETURN his order in
			 * in order to get a replacement or a refund. This is in DAYS */
			$table->integer('buyer_return_window')->unsigned()->default(7);

			/* The window for a merchant to approve a Cancel or Return
			 * request for CRE, in DAYS */
			$table->integer('merchant_approve_cre_window')->
				unsigned()->default(7);

			$table->integer('ocreditcaps_error_margin')->
				unsigned()->default(5);

			/* OCBC transaction fields */
			$table->char('ocbc_branch', 5)->
				default('00790');
			$table->char('ocbc_company_cif', 20)->
				default('A999999');;
			$table->char('ocbc_company_name', 30)->
				default('Intermedius Opensupermall');
			$table->char('ocbc_company_ac_no', 20)->
				default('7901062119');


			/* Generic bank transfer fee (percentage) */
			$table->float('bank_transfer_fee')->unsigned()->default(2.0);
			

			/********* Primary Commission Constraint **********/
			/* The amount our partners are attracted to */
            $table->float('pri_commission_constraint')->unsigned()->default(20);


			/********* Global Default Commission Table **********/
			/* The amount of cut OpenSupermall gets for each RETAIL
			 * transaction from each merchant in percentage */
            $table->float('osmall_commission')->unsigned()->default(10);

			/* The amount of cut OpenSupermall gets for each B2B
			 * transaction from each merchant in percentage */
            $table->float('b2b_osmall_commission')->unsigned()->default(10);

 			/* This is the switch for OpenSupermall's commission type */
			$table->enum('commission_type',
				array('std','var'))->default('std');
			
			$table->enum('b2b_commission_type',
				array('std','var'))->default('std');
 

            /********* Sales commissions below are a cut against **********
             ********* OpenSupermall's commission, as above.     **********/
 			/* The amount of cut a merchant consultant gets for each
			 * transaction, by default 4% */
			$table->float('mc_sales_staff_commission')->unsigned()->default(4);

            /* If merchant acquisition is via internal referral, a then
             *merchant consultant's commission will be reduced to 75% of 4% */
																 /* old: 3% */ 
			$table->float('mc_with_ref_sales_staff_commission')->
				unsigned()->default(0.75);

            /* If a merchant consultant gets a merchant by an internal
             * referral, for each transaction, by default 25%, but the
             * merchant consultant's commission will be reduced to 25% of 4% */
																  /* old: 1% */ 
			$table->float('referral_sales_staff_commission')->
				unsigned()->default(0.25);

            /* Merchant Professional has a potential of 2
             * tiers in commissions */
			$table->float('mcp1_sales_staff_commission')->
				unsigned()->default(5);
			$table->float('mcp2_sales_staff_commission')->
				unsigned()->default(2);

            /* For SMM, 10% is the allocation pool, for total number of
             * "buy" clicks. For individual payout, 10% divided by the
             * "buy" clicks multiplied by how many "buy" a single SMM
             * has generated */
			$table->float('smm_sales_staff_commission')->unsigned()->default(10);

			/* Pusher */
			$table->float('psh_sales_staff_commission')->unsigned()->default(2);

			/* Station Recruiter */
			$table->float('str_sales_staff_commission')->unsigned()->default(2);

			/* OpenWish commission: This is the percentage of commission
			 * that OpenSupermall will deduct from when the duration has
			 * expired */
			$table->float('ow_commission')->unsigned()->default(20);

 			/* The standard annual subscription of a regular merchant in MYR:
			 * Note that this follows standard storage in cents */
			$table->integer('merchant_annual_subscription_fee')
				->unsigned()->default(500000);

  			/* The standard annual subscription of a regular station in MYR:
			 * Note that this follows standard storage in cents */
			$table->integer('station_annual_subscription_fee')
				->unsigned()->default(0);
 
			/* Logistic commission: This is the percentage of commission
			 * that OpenSupermall will markup from shipping cost for each
			 * order that uses our official logistics provider:
			 *
			 * Price which logistics give us:
			 * orderproduct.shipping_cost 
			 *
			 * Price which we sell to buyer: 
			 * orderproduct.order_delivery_price */
			$table->float('logistic_commission')->unsigned()->default(10);

			/* Station Principles */
			/* Principle #1: Station minimum order amount, this is in cents */
			$table->integer('station_min_order')->unsigned()->default(10000);

			/* Delivery Pricing */
			$table->float('cms_pricing')->default(0.05);
			$table->float('grs_pricing')->default(0.02);
			$table->float('mts_pricing')->default(0.01);

			$table->integer('hyper_duration')->unsigned()->default(30);
			$table->integer('openwish_duration')->unsigned()->default(7);

			/* Account suspension logging */
			$table->string('ceo_log_email')->
				default('hiew.intermedius@gmail.com');
			$table->string('cto_log_email')->
				default('waisun.intermedius@gmail.com');

			/* Terms and Condition for Merchants and Stations */
			$table->mediumText('station_agreement');
			$table->mediumText('merchant_agreement');
			$table->integer('agreement_stamping_fee')->
				unsigned()->default(10000);

			/* PMRB Table for PCB Computations */
			$table->text('pmrb_table');

			/* HR: Employment */
			/* SOCSO, less than 60 years old */
			$table->float('socso_less60_employer')->default(1.75);
			$table->float('socso_less60_employee')->default(0.50);
			/* SOCSO, more than 60 years old */
			$table->float('socso_more60_employer')->default(1.25);

			/* EPF, salary less than MYR5000/month */
			/* Employee's contribution */
			$table->float('epf_less5k_employee_A')->default(11.00);/* % */
			$table->float('epf_less5k_employee_B')->default(11.00);/* % */ 
			$table->float('epf_less5k_employee_C')->default(05.50);/* % */ 
			$table->float('epf_less5k_employee_D')->default(05.50);/* % */ 
			/* Employer's contribution */
			$table->float('epf_less5k_employer_A')->default(13.00);/* %   */  
			$table->float('epf_less5k_employer_B')->default(05.00);/* MYR */
			$table->float('epf_less5k_employer_C')->default(06.50);/* %   */  
			$table->float('epf_less5k_employer_D')->default(05.00);/* MYR */

 			/* EPF, salary more than MYR5000/month */
			/* Employee's contribution */
			$table->float('epf_more5k_employee_A')->default(11.00);/* % */
			$table->float('epf_more5k_employee_B')->default(11.00);/* % */ 
			$table->float('epf_more5k_employee_C')->default(05.50);/* % */ 
			$table->float('epf_more5k_employee_D')->default(05.50);/* % */ 
			/* Employer's contribution */
			$table->float('epf_more5k_employer_A')->default(12.00);/* %   */  
			$table->float('epf_more5k_employer_B')->default(05.00);/* MYR */
			$table->float('epf_more5k_employer_C')->default(06.00);/* %   */  
			$table->float('epf_more5k_employer_D')->default(05.00);/* MYR */
			
			/* Buyer Complaint Window.
			 * This is time in days after which the buyer will see a complain
			 * button next to his order, if his order has not been delivered.
			 * IN DAYS*/
			$table->integer('buyer_complaint_window')->default(3);
			
			/* Token Value */
			$table->integer('min_merchant_token_value')->unsigned()->
				default(1000000);
			$table->integer('min_station_token_value')->unsigned()->
				default(1000000);
			$table->integer('token_merchant_id')->unsigned()->default(184);
			$table->integer('token_product_id1')->unsigned()->default(2046);
			$table->integer('token_product_id2')->unsigned()->default(2047);
			$table->integer('token_product_id3')->unsigned()->default(2048);
			$table->integer('token_product_id4')->unsigned()->default(2049);
			$table->integer('token_product_id5')->unsigned()->default(2050);
			
			/*** Maximum Password Attemps ***/
			$table->integer('max_password_fail')->default(5)->unsigned();

			/* Credit Term parameters:
			 * This is the length/duration of which reminder emails will be 
			 * sent out. This is in weeks */
			$table->integer('term_reminder_period')->unsigned()->
				default(4); /* weeks */

			$table->integer('max_password_fail')->unsigned()->default(5);

			$table->integer('email_confirmation_duration')->
				unsigned()->default(72);			

			/* Landing Page Advertisement parameters */
			$table->integer('adv_lp_max_slider_images')->
				unsigned()->default(10);			
			$table->integer('adv_lp_max_oshop_images')->
				unsigned()->default(10);

			/* Facility Monthly User Fee */
			$table->integer('global_monthly_users_fee')->
				unsigned()->default(100);

			/* OPOSsum Product Cache Expiry default age */
			$table->integer('opossum_product_cache_expiry')->
				unsigned()->default(30);

			
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
        Schema::drop('global');
    }
}
