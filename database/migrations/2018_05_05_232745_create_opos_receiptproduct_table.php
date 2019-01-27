<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposReceiptproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_receiptproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receipt_id')->unsigned();
            $table->integer('product_id')->unsigned();

			// This is to support Promotional bundle
            $table->integer('bundle_id')->unsigned();

			// This is actually member.id
            $table->integer('masseur_member_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('delivered')->unsigned()->default(0);
            $table->integer('price')->unsigned();
            $table->float('discount')->unsigned(0);
			// This is the FK to opos_discount.id
            $table->integer('discount_id')->unsigned(0);

			/* These 2 columns are obsolete because service charge is taken
			 * from opos_receipt.servicecharge_id */
            $table->float('servicecharge')->unsigned(0);
            $table->integer('servicecharge_id')->unsigned(0);

			// $table->float('actual_dscounted_amt')->unsigned(0);
            $table->enum('status',[
                "completed",
                "inprogress",
                "partialcooking",
                "cooking",
                "delivered",
                "returned",
                "outfordelivery",
                "cancelled",
                "pending",
                "refunded",
                "partialdelivered",
                "voided",
				        "active"
            ])->default('active');
            $table->integer('saleslog_id')->unsigned()->nullable();
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
        Schema::drop('opos_receiptproduct');
    }
}
