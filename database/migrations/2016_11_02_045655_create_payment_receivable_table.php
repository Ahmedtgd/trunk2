<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentReceivableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('payment_receivable', function (Blueprint $table) {

            $table->increments('id');

			/* This is not relevant as payment_id pertains to
			 * a single porder */
            //$table->integer('payment_id');

            $table->integer('payment_gateway_id');

			/* This is for payment confirmation */
            $table->dateTime('confirmation');

            $table->float('partial')->unsigned();

            $table->text('remarks')->nullable();

            $table->integer('week_number')->nullable();

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
        Schema::drop('payment_receivable');
    }
}
