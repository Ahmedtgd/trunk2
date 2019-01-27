<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawmaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table implements product:rawmaterial = m:n relationship */
        Schema::create('rawmaterial', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('item_product_id')->unsigned(); // finished good
			$table->integer('raw_product_id')->unsigned(); // raw material
			$table->float('raw_qty')->unsigned(); // raw material qty used
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
        Schema::drop('rawmaterial');
    }
}
