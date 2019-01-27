<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMlmOverriding extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlmoverriding', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('mlmlevel_id')->unsigned();
            $table->integer('recruit_ovr')->unsigned();
            $table->integer('newfamily_ovr')->unsigned();
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
        Schema::drop('mlmoverriding');
    }
}
