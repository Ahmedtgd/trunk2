<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReturnOfGood extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_of_goods', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('order_tproduct_id');

            $table->integer('returnofgoods_no')->unsigned();

            $table->integer('quantity');
            $table->integer('station_id');
            $table->integer('merchant_id');
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
        Schema::drop('return_of_goods');
    }
}
