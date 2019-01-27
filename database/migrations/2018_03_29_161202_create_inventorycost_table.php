<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventorycostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventorycost', function (Blueprint $table) {
            $table->increments('id');

			/* seller of the product: can be either:
			 * emerchant.id OR merchant.id */
            $table->integer('seller_merchant_id')->unsigned();

	        /* This identifies whether supplier is from emerchant */
            $table->boolean('is_emerchant');

 			/* buyer of the product */
            $table->integer('buyer_merchant_id')->unsigned();
 
            $table->timestamp('doc_date');
            $table->string('doc_no')->unique();
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
        Schema::drop('inventorycost');
    }
}
