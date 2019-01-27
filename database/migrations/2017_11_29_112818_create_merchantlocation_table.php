<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantlocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* Implements:
		 * merchant:location = 1:m */
        Schema::create('merchantlocation', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('merchant_id')->unsigned();
			$table->integer('location_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
			$table->engine = 'MYISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('merchantlocation');
    }
}
