<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentbreakupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void

        All monteory values are in cents
     */
    public function up()
    {
        Schema::create('paymentbreakup', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porder_id')->unsigned();
            /*Total Value*/ 
            $table->integer('total')->unsigned();
           /*Portion paid via ocredit*/ 
            $table->integer('ocredit')->unsigned()->default(0);
            /* Portion paid via other methods such as internet banking or cart*/ 
            $table->integer('banking')->unsigned()->default(0);
            /*Total Delivery*/ 
            $table->integer('total_delivery')->unsigned()->default(0);
            /* delivery price*/ 
            $table->integer('raw_delivery')->unsigned()->default(0);
            /* our commission on delivery */ 
            $table->integer('logistic_commission')->unsigned()->default(0);
            /* Administrative fee for each porder */ 
            $table->integer('order_administration_fee')->unsigned()->default(0);
            $table->integer('delivery_administration_fee')->unsigned()->default(0);
            $table->integer('payment_gateway_commission')->unsigned()->default(0);
            // $table->integer('gst_on_delivery')->unsigned()->default(0);
            $table->integer('bank_transfer_fee')->unsigned()->default(0);
            // Others -> for anything we left out in hindsight
            $table->integer('other')->unsigned()->default(0);
            /*Surcharge on payment by card*/ 
            $table->integer('surcharge')->unsigned()->default(0);
            // $table->integer('')->unsigned()->default(0);
            // $table->integer('')->unsigned()->default(0);
            // $table->integer('')->unsigned()->default(0);
            // $table->integer('')->unsigned()->default(0);
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
        Schema::drop('paymentbreakup');
    }
}
