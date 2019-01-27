<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
        History:
        We gave the merchant the power to break an order into multiple deliviries. To track which products of the order went for which delivery, we created this table. 

     */
    public function up()
    {
        Schema::create('deliveryproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_id')->unsigned();
            $table->integer('product_id')->unsigned();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deliveryproduct');
    }
}
