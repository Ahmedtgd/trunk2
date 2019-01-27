<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesStaffproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* A sales_staff can be associated to many products, while a product can be 
		 * sold by many sales_staff */
        Schema::create('sales_staffproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_staff_id')->unsigned();
            $table->integer('product_id')->unsigned;

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
        Schema::drop('sales_staffproduct');
    }
}
