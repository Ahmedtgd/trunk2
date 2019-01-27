<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNcreidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncreid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('ncre_id')->unique();
			$table->integer('cre_id')->unsigned();
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
        Schema::drop('ncreid');
    }
}
