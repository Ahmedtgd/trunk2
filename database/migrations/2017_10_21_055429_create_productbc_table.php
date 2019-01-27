<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductbcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		/* This table implement product:barcode = m:n relationship:
		 * Case 1: product_id:barcode = 1:1
		 *		   One product_id cannot be mapped to more than one barcode
		 *
		 * Case 2: barcode:product_id = 1:m
		 *		   One barcode can belong to many product ids, this represents
		 *		   the same product coming from different suppliers
		 */
		Schema::create('productbc', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('bc_management_id')->unsigned()->unique();
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
		Schema::drop('productbc');
	}
}
