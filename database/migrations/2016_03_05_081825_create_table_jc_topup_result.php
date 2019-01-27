<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJcTopupResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jc_topup_result', function (Blueprint $table) {
            $table->increments('id');
            $table->char('trans_type',6)->default('TP_RST');

			/* Integer */
            $table->string('trans_id');

			/* Mobile number: 601xxxxxxxx */
            $table->string('target_msisdn');

			/* Date of this transaction: YYYYMMDD */
            $table->date('trans_date');

			/* Time of this transaction (24 hrs): HHMMSS */
            $table->time('trans_time');

			/* 'SUCCESS' or 'FAILED' */
            $table->char('tp_result',7);

			/* Empty if SUCCESS */
            $table->string('fail_reason');

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
        Schema::drop('jc_topup_result');
    }
}
