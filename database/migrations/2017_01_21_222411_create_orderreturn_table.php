<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderreturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderreturn', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porder_id')->unsigned();
            $table->integer('user_id')->unsigned();
            /*Future Use*/
            $table->integer('orderproduct_id')->unsigned();
            // 
            $table->integer('return_price')->unsigned();
            $table->enum('status', array('success','failed'
            ));
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
        Schema::drop('orderreturn');
    }
}
