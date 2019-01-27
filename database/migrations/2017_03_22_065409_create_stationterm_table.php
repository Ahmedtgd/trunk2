<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationtermTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationterm', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->integer('creditor_user_id')->unsigned();
			$table->integer('station_id')->unsigned();
			$table->integer('term_duration')->unsigned();
			$table->integer('credit_limit')->unsigned();
			$table->integer('salesman_id')->unsigned();
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
         Schema::drop('stationterm');
    }
}
