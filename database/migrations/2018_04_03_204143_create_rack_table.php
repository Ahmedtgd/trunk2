<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rack', function (Blueprint $table) {
            $table->increments('id');

			/* This is a per warehouse unsigned integer sequence */
			$table->integer('rack_no')->unsigned();

			$table->integer('warehouse_id')->unsigned();
			$table->string('name');
			$table->string('description');

			/* Physical size of rack */
			$table->string('size');	

			/* For future use, potentially useful  */
			$table->integer('capacity'); 
			$table->string('remarks'); 

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
        Schema::drop('rack');
    }
}
