<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StockreportrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockreportrack', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stockreport_id')->unsigned();
            $table->integer('rack_id')->unsigned();
            $table->softDeletes();
            $table->engine = "MYISAM";
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
        Schema::drop('stockreportrack');
    }
}
