<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationdirectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationdirector', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('station_id');
            $table->integer('director_id');
            $table->enum('deleted_at',array('0','1'))->default("0");
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
        Schema::drop('stationdirector');
    }
}
