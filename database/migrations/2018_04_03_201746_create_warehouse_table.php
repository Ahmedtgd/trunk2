<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('description');

			/* The company which owns this warehouse */
			$table->integer('company_id')->unsigned();

			/* Location of the warehouse */
			$table->integer('location_id')->unsigned();

			/* OPTIONAL: Address of this warehouse */
			$table->integer('address_id')->unsigned();

			/* OPTIONAL: Contact person */
			$table->string('first_name');
			$table->string('last_name');
			$table->string('designation');
			$table->string('mobile_no');
			$table->string('email');

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
        Schema::drop('warehouse');
    }
}
