<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorder', function (Blueprint $table) {
            $table->increments('id');
 			$table->integer('purchaseorder_no')->unsigned();

			/* This can be emerchant_id for unregistered merchant
			 * or merchant_id for registered merchant */
 			$table->integer('supplier_id')->unsigned();

			$table->string('description');
			/* This stores the monetary value in cents in the DB */
			$table->integer('total')->unsigned();
			$table->enum('status',
				['active','pending','approved','rejected'])->
				default('active');
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
        Schema::drop('purchaseorder');
    }
}
