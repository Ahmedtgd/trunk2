<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idlog', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyinteger('day_pos')->unsigned();
            $table->tinyinteger('mth_pos')->unsigned();
            $table->tinyinteger('yr_pos')->unsigned();
            $table->tinyinteger('hr_pos')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('idlog');
    }
}
