<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table keep tracks of products and their flow in a 
		 * in a particular location */
        Schema::create('locationproduct', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('location_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('stocktransfer_id')->unsigned();
			$table->integer('opening_balance')->unsigned();
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
        Schema::drop('locationproduct');
    }
}
