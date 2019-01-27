<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposReceiptproductspecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_receiptproductspecial', function (Blueprint $table) {
            $table->increments('id');
            /*FK opos_receiptproduct*/
            $table->integer('receiptproduct_id')->unsigned();
            /*FK plat_special*/
            $table->integer('special_id')->unsigned();
            $table->integer('quantity')->default(1);
            $table->enum('type',['more','less']);
            $table->enum('status',['active','deleted','pending']);
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
        Schema::drop('opos_receiptproductspecial');
    }
}
