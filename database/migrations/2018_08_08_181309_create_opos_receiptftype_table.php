<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposReceiptftypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_receiptftype', function (Blueprint $table) {
            $table->increments('id');
			/* FK to opos_receipt.id */
			$table->integer('receipt_id')->unsigned();
			/* FK to opos_ftype.id */
			$table->integer('ftype_id')->unsigned();
			$table->enum('ftype',['lockerkey','sparoom','hotelroom','car','table']);
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
        Schema::drop('opos_receiptftype');
    }
}
