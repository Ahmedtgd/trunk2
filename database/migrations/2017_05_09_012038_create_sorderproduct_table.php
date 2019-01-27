<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSorderproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorderproduct', function (Blueprint $table) {
            $table->increments('id');

            /* Station which got assigned to this order from the 
             * merchant/manufacturer/supplier. This means the station can
             * be a SELLER too, taking deals from the principal/manufacturer */
            $table->integer('station_id')->unsigned();

            /* Note:
             * When a station orders stock from a merchant/manufacturer via
             * B2B, it generates a regular porder */


            /* Points to original product order */
            $table->integer('orderproduct_id')->unsigned();

            /* Current order quantity. Only relevant if the station is
             * a buyer. By default should be the same as the previous order.
             * Otherwise, a new value shoud be able to be keyed in */
            $table->integer('order_qty')->unsigned();

            /* Current shipping cost for the ORDER.
             * Which may be different from the pervious time */
            $table->integer('shipping_cost')->unsigned();

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
        Schema::drop('sorderproduct');
    }
}
