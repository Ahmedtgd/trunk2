<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentresponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentresponse', function (Blueprint $table) {
            $table->increments('id');
			// FK to our OWN payment table
            $table->integer('payment_id');

            $table->string('merchant_code', 20);
            $table->integer('ipay88_payment_id');
            $table->string('ref_no', 20);
            $table->float('amount');
            $table->string('currency', 5);
            $table->string('remark', 100);
            $table->string('trans_id', 30);
            $table->string('auth_code', 20);

			// Payment status: "1"=success, "0"=fail
			$table->enum('status',array('0','1'))->default("0");

			$table->string('err_desc', 100);
			$table->string('signature', 100);

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
        Schema::drop('paymentresponse');
    }
}
