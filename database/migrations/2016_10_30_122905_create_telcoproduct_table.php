<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelcoproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This relates all the products which a telco can supply
	   	 * telco:product = 1:m */
        Schema::create('telcoproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telco_id')->unsigned();
            $table->integer('product_id')->unsigned();
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
        Schema::drop('telcoproduct');
    }
}
