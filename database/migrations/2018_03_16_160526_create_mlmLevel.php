<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMlmLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlmlevel', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('mlmcomm_id')->unsigned();
            $table->integer('level_no')->unsigned();
            $table->integer('pers_comm')->unsigned();
            $table->integer('cachv')->unsigned();
            $table->integer('cachv_gbonus')->unsigned();
            $table->integer('cnot_achv')->unsigned();
            $table->integer('cnot_achv_gbonus')->unsigned();

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
        Schema::drop('mlmlevel');
    }
}
