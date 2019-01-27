<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderdeliveryPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderdeliverypath', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porder_id')->unsigned();
            $table->integer('delivery_id')->unsigned()->nullable();
            $table->integer('path_no')->unsigned();
            $table->integer('statusstate_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('orderdeliverypath');
    }
}

