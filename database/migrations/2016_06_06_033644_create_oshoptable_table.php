<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOshoptableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oshoptable', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('merchant_id')->unsigned();

			/* Table code: unique string to identify a table */
			$table->string('tcode');

			/* Table capacity in pax  */
			$table->integer('tpax')->unsigned();

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
        Schema::drop('oshoptable');
    }
}
