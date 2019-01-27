<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcreditDebitLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocredit_debit_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ocredit_id')->unsigned();
            $table->integer('debited_from')->unsigned();
            $table->integer('value')->unsigned();
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
        Schema::drop('ocredit_debit_log');
    }
}
