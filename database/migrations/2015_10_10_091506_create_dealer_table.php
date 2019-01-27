<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDealerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dealer', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unique()->unsigned();

            /* Which merchant consultant brought this dealer in?
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
 
            /* Commission table per merchant */
            $table->float('osmall_commission')->unsigned();
            $table->float('b2b_osmall_commission')->unsigned();
            $table->float('mc_sales_staff_commission')->unsigned();
            $table->float('mc_with_ref_sales_staff_commission')->unsigned();
            $table->float('referral_sales_staff_commission')->unsigned();
            $table->float('mcp1_sales_staff_commission')->unsigned();
            $table->float('mcp2_sales_staff_commission')->unsigned();
            $table->float('smm_sales_staff_commission')->unsigned();
            $table->float('psh_sales_staff_commission')->unsigned();
            $table->float('str_sales_staff_commission')->unsigned();
 

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
		Schema::drop('dealer');
	}

}
