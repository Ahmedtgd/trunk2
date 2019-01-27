<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDtMerchantproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_merchantproduct', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('merchant_id')->unsigned();
			$table->index('merchant_id','mp_merchant_id_idx');

			$table->integer('product_id')->unsigned()->unique();
			$table->index('product_id','mp_product_id_idx');

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
        Schema::drop('dt_merchantproduct');
    }
}
