<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* What is contained in a merchant profile */
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');

			/* This where we choose the resources from */
            $table->integer('album_id')->unsigned();

			/* profile:theme = 1:m, so profile FK must be in theme table */
            $table->integer('theme_id')->unsigned();

            $table->integer('signboard_id')->unsigned();
            $table->integer('bunting_id')->unsigned();
            $table->integer('vbanner_id')->unsigned();

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
        Schema::drop('profile');
    }
}
