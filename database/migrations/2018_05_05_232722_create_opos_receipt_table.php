<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_receipt', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('receipt_no')->unsigned();
			$table->integer('cash_received')->unsigned();
			$table->integer('servicecharge_id')->unsigned();
			$table->enum('payment_type',
				['cash','creditcard','various'])->unsigned();
			$table->enum('points',['opencredit','other'])->unsigned();
			$table->integer('otherpoints')->unsigned();
			$table->integer('opencredit')->unsigned();
			$table->integer('terminal_id')->unsigned();
			$table->integer('staff_user_id')->unsigned();
			$table->string('creditcard_no');
            $table->enum('mode',['inclusive','exclusive'])->default('inclusive');
			$table->string('ref_no');
			$table->enum('status',enum(
				'active','confirmed','printed','voided','frozen',
				'completed','refunded'))->default('active');

			$table->string('remark');
			$table->string('otherpoints_remark');
            $table->integer('cash_10k')->unsigned()->default(0);
            $table->integer('cash_1k')->unsigned()->default(0);
			$table->integer('cash_100')->unsigned()->default(0);
			$table->integer('cash_50')->unsigned()->default(0);
			$table->integer('cash_20')->unsigned()->default(0);
			$table->integer('cash_10')->unsigned()->default(0);
			$table->integer('cash_5')->unsigned()->default(0);
			$table->integer('cash_2')->unsigned()->default(0);
			$table->integer('cash_1')->unsigned()->default(0);
			$table->integer('cents_1')->unsigned()->default(0);
			$table->integer('cents_5')->unsigned()->default(0);
			$table->integer('cents_10')->unsigned()->default(0);
			$table->integer('cents_20')->unsigned()->default(0);
			$table->integer('cents_50')->unsigned()->default(0);
			/*Stores rounded of value. Can be negative*/
			$table->integer('round')->default(0);
			/*Service Tax is NOT Service Charge*/
			$table->float('service_tax')->default(0);
			$table->timestamp('voided_at')->default(null);
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
        Schema::drop('opos_receipt');
    }
}
