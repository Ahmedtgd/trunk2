<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposReceiptproductsaleslogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_receiptproductsaleslog', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receiptproduct_id')->unsigned();
            $table->integer('saleslog_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('opos_receiptproductsaleslog');
    }
}
