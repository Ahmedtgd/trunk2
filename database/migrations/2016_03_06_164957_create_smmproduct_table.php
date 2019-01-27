<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmmproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smmproduct', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('smm_sales_staff_id')->unsigned();
			$table->integer('product_id')->unsigned();

			/* SMM posts have a lifetime, and can be expired. Expiry duration
			 * in global.smm_expiry is in days */
			$table->enum('status', ['active','expired']);

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
        Schema::drop('smmproduct');
    }
}
