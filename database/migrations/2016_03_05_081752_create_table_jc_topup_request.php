<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJcTopupRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jc_topup_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dealer_id')->default('intermedius');
            $table->char('trans_type',2)->default('TP');

			/* Unique number for tracking */
            $table->string('trans_id');

			/* Target mobile number: 601xxxxxxxx */
            $table->string('target_msisdn');

			/* Telco code:
			 * CC - Celcom
			 * DG - DiGi
			 * MX - Maxis
			 * MT - MerchanTrade
			 * TUNE - TuneTalk
			 * UM - U-Mobile */
            $table->char('telco_code',5);

			/* Top-up amount */
            $table->integer('tp_denom');

			/* Date of this transaction: YYYYMMDD */
            $table->date('trans_date');

			/* Time of this transaction (24 hrs): HHMMSS */
            $table->time('trans_time');

			/* Verification Code */
            $table->string('veri_code');

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
        Schema::drop('jc_topup_request');
    }
}
