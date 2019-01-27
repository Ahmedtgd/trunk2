<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDtNproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_nproductid', function (Blueprint $table) {
 			$table->increments('id')->unsigned();
			$table->string('nproduct_id')->unique();
			$table->integer('product_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
			$table->engine = "MyISAM"; 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dt_nproductid');
    }
}
