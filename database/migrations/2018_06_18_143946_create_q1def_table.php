<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQ1defTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   		/* This table captures the definition of Quantity of 1, required by
		 * recipe and raw material defintion */
        Schema::create('q1def', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned;
            $table->integer('measurement')->unsigned;

			// This is going to be deprecated. Unit values will move to uom table
            $table->enum('unit',['g','mg','kg','mm','cm','m',
				'l','ml','pax','piece']);

			$table->integer('uom_id')->unsigned;

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
        Schema::drop('q1def');
    }
}
