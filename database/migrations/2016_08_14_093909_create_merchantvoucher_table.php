<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantvoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchantvoucher', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('merchant_id')->unsigned();
			$table->integer('voucher_id')->unsigned();
			$table->enum('status', ['active','consumed','expired']);
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
        Schema::drop('merchantvoucher');
    }
}
