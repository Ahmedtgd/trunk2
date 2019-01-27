<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCprofileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table stores the content of the company profile */
        Schema::create('cprofile', function (Blueprint $table) {
            $table->increments('id');
			$table->text('cover');
			$table->text('contents');
			$table->text('ch1');	/* People */
			$table->text('ch2');	/* Innovation & Creation */
			$table->text('ch3');	/* Risk Management */
			$table->text('ch4');	/* Competitive Advantage */
			$table->text('ch5');	/* Target Market */
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
        Schema::drop('cprofile');
    }
}
