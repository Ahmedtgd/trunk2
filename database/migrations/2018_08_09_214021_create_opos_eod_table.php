<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposEodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_eod', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eod_presser_user_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->timestamp('eod');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::drop('opos_eod');
    }
}
