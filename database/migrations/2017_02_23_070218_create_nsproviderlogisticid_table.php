<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNsproviderlogisticidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nsproviderlogisticid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('nsproviderid_id')->unsigned();
			$table->integer('logistic_id')->unsigned();
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
        Schema::drop('nsproviderlogisticid');
    }
}
