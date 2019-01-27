<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposRefundlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table records all refunds against product via receipts */
        Schema::create('opos_refundlog', function (Blueprint $table) {
            $table->increments('id');

			/* This is the primary FK back to opos_receiptproduct */
			$table->integer('receiptproduct_id')->unsigned();

 			/* ------- To support Refund --------
				X  reject:        Approached but non-refundable
				C  cash:          Cash Refund
				Cx cash_dmg:      Cash Refund (Damage)
				S  exch_same:     Exchange of Same Stocks
				Sx exch_same_dmg: Exchange of Same Stocks (Damaged)
				D  exch_diff:     Exchange with different Stocks 
				Dx exch_diff_dmg: Exchange with different Stocks (Damaged)
			*/ 
			$table->enum('refund_type',['X','C','Cx','S','Sx','D','Dx']);
			$table->integer('refund_topup')->unsigned();
			$table->string('refund_remark');
 			$table->enum('status',[
				'active','rf_rejected','rj_approved','pending','active'
			])->default('null');
 
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
        Schema::drop('opos_refundlog');
    }
}
