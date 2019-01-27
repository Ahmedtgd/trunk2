<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sproduct', function (Blueprint $table) {
            $table->increments('id');
            /*
                This is the original product_id which comes from the orderproduct. Please do not change it.
            */ 
            $table->integer('product_id')->unsigned();

 			/* Current order quantity. By default should be the same as
			 * the previous order. Otherwise, a new value shoud be able
			 * to be keyed in */
			// Should be in table sorder...
            //$table->integer('order_qty')->unsigned();

			/* Current level of product inventory, or what is currently
			 * available */
            $table->integer('available')->unsigned()->default(0);

			/* The original intended stock */
            $table->integer('stock')->unsigned()->default(0);

			/* Current shipping cost for the PRODUCT.
			 * Which may be different from the pervious time */
            $table->integer('shipping_cost')->unsigned();

             /* Status */
            $table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected','deleted'))->
				default('pending'); 

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
        Schema::drop('sproduct');
    }
}
