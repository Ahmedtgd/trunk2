<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagedimensionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('packagedimension', function (blueprint $table) {
            $table->increments('id');
            $table->integer('consignment_number')->unsigned();

            // length, height and width are in "centimeter (cm)"
            $table->float('height')->unsigned();
            $table->float('length')->unsigned();
            $table->float('width')->unsigned();

			// weight is in "kilogram (kg)"
            $table->float('weight')->unsigned();

            $table->softdeletes();
            $table->timestamps();
            $table->engine = "myisam";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('packagedimension');
    }
}
