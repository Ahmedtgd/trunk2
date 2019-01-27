<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table stores all the products which are being kept 
		 * by a station */
        Schema::create('stationsproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_id')->unsigned();
            $table->integer('sproduct_id')->unsigned();
			$table->boolean('enabled')->default(true);
            $table->float('fair_commission')->unsigned()->nullable();
			$table->index(['station_id', 'sproduct_id']);
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
        Schema::drop('stationsproduct');
    }
}
