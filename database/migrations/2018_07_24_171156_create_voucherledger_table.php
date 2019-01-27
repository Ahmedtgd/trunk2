<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherledgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucherledger', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('voucher_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('staff_user_id')->unsigned();
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
        Schema::drop('voucherledger');
    }
}
