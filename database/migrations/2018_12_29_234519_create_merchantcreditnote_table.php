<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantcreditnoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchantcreditnote', function (Blueprint $table) {
            $table->increments('id');
 			$table->integer('merchant_id')->unsigned();
			$table->integer('creditnote_id')->unsigned();
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
        Schema::drop('merchantcreditnote');
    }
}
