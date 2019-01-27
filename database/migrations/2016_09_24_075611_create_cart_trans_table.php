<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTransTable extends Migration
{
    /**
     * Run the migrations.
     * This table is the connecting link between ref_no and the Cart identifiers
     * @return void
     */
    public function up()
    {
        Schema::create('ctrans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_no');
            $table->integer('cart_id')->unsigned(); 
            $table->integer('address_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ctrans');
    }
}
