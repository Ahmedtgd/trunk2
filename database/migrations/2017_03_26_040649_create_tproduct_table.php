<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tproduct', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			/* Track child records for B2C, B2B, Hyper */
			$table->integer('parent_id')->unsigned();
			$table->integer('product_id')->unsigned();
			/* Segment identifier */
			$table->enum('segment', ['b2c','b2b','hyper','v1','v2','custom'])->default('b2c');


			/* We support 5 product photos */
			$table->string('photo_1');
			$table->string('photo_2');
			$table->string('photo_3');
			$table->string('photo_4');
			$table->string('photo_5');

			/* OShop and description should be at merchant table
			$table->string('oshop');
			$table->string('description');
			 */

			// /* This is product description */                    ->nullable()
			$table->text('description');

			$table->boolean('free_delivery')->default(false);
			$table->integer('free_delivery_with_purchase_qty')->nullable();
			$table->integer('free_delivery_with_purchase_amt')->nullable();

			/* B2C Delivery price & coverage  | DO NOT CHANGE ORDER> THEY ARE LINKED*/
			$table->integer('del_west_malaysia')->unsigned()->default(0);
			$table->integer('del_sabah_labuan')->unsigned()->default(0);
			$table->integer('del_sarawak')->unsigned()->default(0);
			$table->integer('del_worldwide')->unsigned()->default(0);
			$table->integer('cov_country_id')->unsigned()->nullable();
			$table->integer('cov_state_id')->unsigned()->nullable();
			$table->integer('cov_city_id')->unsigned()->nullable();
			$table->integer('cov_area_id')->unsigned()->nullable();

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

			/* Current Retail (B2C) stock availability or stock count */
			$table->integer('available')->unsigned()->nullable();
			$table->integer('warehouse_available')->unsigned()->nullable();
			$table->integer('tproductdetail_id')->unsigned();

			/* Commission table per product */
			$table->float('osmall_commission')->unsigned()->nullable();
			$table->float('b2b_osmall_commission')->unsigned()->nullable();

            /* Status */
            $table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected','deleted'))->
				default('active');

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
        Schema::drop('tproduct');
    }
}
