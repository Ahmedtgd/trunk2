<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderproductwarrantyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table relates a product in an order its IMEI no.
		 * and its warranty_no if exists */
        Schema::create('orderproductwarranty', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('orderproductqty_id')->unsigned();

			/* This can be used for IMEI No. for phone products. There is 
			 * redundancy due to evolution of storing the actual serial_no
			 * string. This is actually the same as
			 * bc_management.barcode */
			$table->string('serial_no')->nullable();

			/* Once validation module is in production, we are just linked via
			 * FK to the bc_management table to the actual barcode, which 
			 * has been verified. We record whether this serial_no has been
			 * used in any invoices */
			$table->integer('serial_bc_mgmt_id')->unsigned();
			$table->boolean('serial_used')->default(false);

			/* This is the same story with warranty_no. Warranty's full
			 * flow has not been fully fleshed out as of 2019-01-12. This
			 * is actually the same as bc_management.barcode */
			$table->string('warranty_no')->nullable();

			/* Again warranty_no is a link to bc_management table to the
			 * actual barcode. We record whether this warranty_no has been
			 * used in any invoices */
			$table->integer('warranty_bc_mgmt_id')->unsigned();
			$table->boolean('warranty_used')->default(false);

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
        Schema::drop('orderproductwarranty');
    }
}
