<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmaChannelLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smma_channel_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('smma_log_id')->unsigned();
            $table->integer('smma_channel_id')->unsigned();
            $table->integer('smmout_id')->unsigned();
            $table->enum('channel_type',['fb','email','others']);
            $table->enum('status',['success','failed','pending'])->default('pending'); 
            $table->string('error_code');
            $table->string('error_desc');
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
        Schema::drop('sma_channel_log');
    }
}
