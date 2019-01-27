<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNocreditidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nocreditid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('nocredit_id')->unique();
			$table->integer('ocredit_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
			$table->engine = "MyISAM";
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nocreditid');
    }
}
