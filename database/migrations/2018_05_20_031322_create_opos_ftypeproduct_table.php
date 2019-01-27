<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposFtypeproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This tables provides the attachment and tracking of products which
		 * are attached to a multitude of facility types: e.g. sparoom and
		 * hotelroom */
        Schema::create('opos_ftypeproduct', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('ftype_id')->unsigned();
			$table->integer('product_id')->unsigned();
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
        Schema::drop('opos_ftypeproduct');
    }
}
