<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposBundleproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_bundleproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bundle_id')->unsigned();
            $table->integer('product_id')->unsigned();

			// Bundle product discount in percentage:
			// Applied to products in a bundle
            $table->float('bpdiscount')->unsigned();
			// Bundle product quantity
            $table->integer('bpqty')->unsigned();
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
        Schema::drop('opos_bundleproduct');
    }
}
