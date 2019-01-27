<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistricenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districenter', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_id')->unsigned();

			/* Districenter details */
            $table->string('dc_name');
            $table->string('contact_name');
            $table->string('contact_number');
            $table->integer('address_id')->unsigned();

			/* Capacity or size of the warehouse: in Square Feet */
            $table->integer('capacity');

			/* These are features of the warehouse, able to store
			 * specific forms of packages */
            $table->boolean('parcel')->default(true);
            $table->boolean('container')->default(false);
            $table->boolean('palette')->default(false);
            $table->boolean('perishable')->default(false);


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
        Schema::drop('districenter');
    }
}
