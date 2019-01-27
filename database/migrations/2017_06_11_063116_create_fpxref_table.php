<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFpxrefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fpxref', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ref_no')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('fpx_ar_id')->unsigned();
            $table->string('cart_session_id')->unsigned();
            $table->string("fpx_resp");
            $table->integer('tries')->unsigned()->default(1); 
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
        Schema::drop('fpxref');
    }
}
