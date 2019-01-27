<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->integer('brand_id')->unsigned();

			/* Track child records for B2C, B2B, Hyper */
			$table->integer('parent_id')->unsigned();

			/* Primary category_id */
			$table->integer('category_id')->unsigned();

			/* This is the level nth of subcategory */
			$table->integer('subcat_id')->unsigned();
			$table->integer('subcat_level')->unsigned()->default(1);

			/* Segment identifier */
			$table->enum('segment',
				['b2c','b2b','hyper','v1','v2','custom','token',
				 'treport','tin','tout','smemo','platypos','opossum'])->
				default('b2c');
				
			/* Delivery Mode */
			$table->enum('delivery_mode',
				['system','own','pick-up','rstorage'])->
				default('system');	

			/* We support 5 product photos */
			$table->string('photo_1');
			$table->string('photo_2');
			$table->string('photo_3');
			$table->string('photo_4');
			$table->string('photo_5');

			/* We support 2 thumbnail images */
			$table->string('thumb_photo');	/* 253px x 200px */
			$table->string('thumb_photo2');	/* 380px x 400px */

			/* These are images for advertisment slots */
			$table->string('adimage_1');
			$table->string('adimage_2');
			$table->string('adimage_3');
			$table->string('adimage_4');
			$table->string('adimage_5');

			/* OShop and description should be at merchant table
			$table->string('oshop');
			$table->string('description');
			 */

			/* This is product description */
			$table->text('description');

			$table->boolean('free_delivery')->default(false);
			$table->boolean('flat_delivery')->default(false);
			$table->integer('free_delivery_with_purchase_qty')->nullable();
			$table->integer('free_delivery_with_purchase_amt')->nullable();
			/* Number of views, simple increment upload reload of
			 * product view */
			$table->integer('views')->unsigned()->default(0);

			/* This will display the wholesale price for non-dealers; i.e.
			 * those not in autolink table will see the wholesale prices */
			$table->boolean('display_non_autolink')->default(false);

			/* B2C Delivery price & coverage
			 * DO NOT CHANGE ORDER, THEY ARE LINKED*/
			$table->integer('del_west_malaysia')->unsigned()->default(0);
			$table->integer('del_sabah_labuan')->unsigned()->default(0);
			$table->integer('del_sarawak')->unsigned()->default(0);
			$table->integer('del_worldwide')->unsigned()->default(0);
			$table->integer('cov_country_id')->unsigned()->nullable();
			$table->integer('cov_state_id')->unsigned()->nullable();
			$table->integer('cov_city_id')->unsigned()->nullable();
			$table->integer('cov_area_id')->unsigned()->nullable();

  			/* B2B Delivery price & coverage */
			$table->integer('b2b_del_worldwide')->unsigned()->default(0);
			$table->integer('b2b_del_west_malaysia')->unsigned()->default(0);
			$table->integer('b2b_del_sabah_labuan')->unsigned()->default(0);
			$table->integer('b2b_del_sarawak')->unsigned()->default(0);
			$table->integer('b2b_cov_country_id')->unsigned()->nullable();
			$table->integer('b2b_cov_state_id')->unsigned()->nullable();
			$table->integer('b2b_cov_city_id')->unsigned()->nullable();
			$table->integer('b2b_cov_area_id')->unsigned()->nullable();
 
			/* Logistic & Delivery options */
			$table->float('del_pricing')->unsigned()->default(0);
			$table->float('del_width')->unsigned()->default(0);
			$table->float('del_lenght')->unsigned()->default(0);
			$table->float('del_height')->unsigned()->default(0);
			$table->float('del_weight')->unsigned()->default(0);			
			$table->float('length')->unsigned()->default(0);
			$table->float('width')->unsigned()->default(0);
			$table->float('height')->unsigned()->default(0);
			$table->float('weight')->unsigned()->default(0);
			$table->enum('del_option', ['own','system','pickup'])->default('own');
 
			/* Deprecated: DO NOT USE! */
			//$table->integer('original_price')->unsigned();

			/* Current use */
			$table->integer('retail_price')->unsigned();
			$table->integer('discounted_price')->unsigned();
			$table->integer('private_retail_price')->unsigned();
			$table->integer('private_discounted_price')->unsigned();

			/* Stock level immediately upon reorder */
			$table->integer('stock')->unsigned();

			/* Current Retail (B2C) stock availability or stock count */
			$table->integer('available')->unsigned()->nullable();
			$table->integer('private_available')->unsigned()->nullable();
			$table->integer('warehouse_available')->unsigned()->nullable();

			/* Current Wholesale (B2B) stock availability or stock count */
			$table->integer('b2b_available')->unsigned()->nullable();

			/* Current Hyper (owarehouse) stock availability or stock count */
			$table->integer('hyper_available')->unsigned()->nullable();

			/* Current Consignment stock availability */
			$table->integer('consignment')->unsigned()->default(0);

			/* O-Warehouse */
			$table->integer('owarehouse_moq')->unsigned();
			//$table->integer('owarehouse_moqpb')->unsigned();
			$table->integer('owarehouse_moqperpax')->unsigned();
			$table->integer('owarehouse_price')->unsigned();
			$table->enum('owarehouse_measure',
				array('box','carton','container','unit'));

			/* Number of units in a measure; box, carton, container, etc. */
			$table->integer('owarehouse_units')->unsigned();
			$table->integer('owarehouse_ave_unit_price')->unsigned();
			/* Dictates whether this product is selected for O-warehouse */
			$table->integer('owarehouse_duration')->default(30);

			/* Merchant:Product  = m:n, => merchantproduct table */
			/* SpcialPrice => merchantproduct table */

			/* Product:Wholesale (Unit/Price) = 1:n, => wholesale table */
			/* Wholesale price can affect multiple dealers:
			 * 		Product:Dealer = m:n, => productdealer table

			/* Category:Specification = 1:m */
			/* Subcategory L1:Specification = 1:m */
			/* Subcategory L2:Specification = 1:m */
			/* Subcategory L3:Specification = 1:m */

			/* This has been migrated to productdetail.data */
			//$table->longtext('product_details');

			/* Added a new product type: extended warranty */
			$table->enum('type', array('product', 'voucher','otcvoucher',
				'platypos','service','warranty'));

			/* Voucher related fields */
			$table->integer('voucher_qty_limit')->unsigned();
			$table->integer('voucher_package_qty')->unsigned();
			$table->datetime('expiry_date');

			/* Dictates whether this product is selected for SMM marketing */
			$table->boolean('smm_selected')->default(false);

			/* Dictates whether this product is selected for display in OShop.
			 * This corresponds to the left-most checkbox in:
			 * "/album#product-detail" */
			$table->boolean('oshop_selected')->default(false);

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

			/* Commission table per product */
			$table->float('osmall_commission')->unsigned()->nullable();
			$table->float('b2b_osmall_commission')->unsigned()->nullable();
			$table->float('mc_sales_staff_commission')->unsigned()->nullable();
			$table->float('mc_with_ref_sales_staff_commission')->unsigned()->nullable();
			$table->float('referral_sales_staff_commission')->unsigned()->nullable();
			$table->float('mcp1_sales_staff_commission')->unsigned()->nullable();
			$table->float('mcp2_sales_staff_commission')->unsigned()->nullable();
			$table->float('smm_sales_staff_commission')->unsigned()->nullable();
			$table->float('psh_sales_staff_commission')->unsigned()->nullable();
			$table->float('str_sales_staff_commission')->unsigned()->nullable();


			/* Setting the number of maximum products under SMM should be
			 * in the merchant table */
			//$table->smallinteger('smm_quota_max')->default(1);

			/* Specialization from the merchant-level fields */
			$table->text('return_policy');
			$table->integer('return_address_id')->unsigned();

            /* Status */
            $table->enum('status', array('pending','transferred','active',
				'dormant','barred','suspended','rejected','deleted'))->
				default('pending');

			/* To signify whether this product is Term enabled */
			$table->boolean('term')->default(false);
			
			$table->integer('delivery_time')->default(5);
			$table->integer('delivery_time_to')->default(7);

            $table->timestamp('active_date');

			/* 1:1 Mapping of product_id:sku */
			$table->string('sku');

			/* Merchant cashback in % percent,
			   controlled in Album/Product List */
			$table->float('cashback')->unsigned()->default(0.0);
			$table->float('private_cashback')->unsigned()->default(0.0);

 			/* Platform cashback in % percent,
			   controlled in Admin/Product Master */
			$table->float('pcashback')->unsigned()->default(0.0);
 			
 			// Specification -> Has Serial Number/IMEI affects warranty
 			$table->boolean('has_serialno')->default(false);
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
	public function down() {
		Schema::drop('product');
	}
}
