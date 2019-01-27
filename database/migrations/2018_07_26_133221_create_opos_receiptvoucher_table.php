<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposReceiptvoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_receiptvoucher', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('receipt_id')->unsigned();
            $table->integer('voucher_id')->unsigned();
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
        Schema::drop('opos_receiptvoucher');
    }
}
