<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNbranchoutletidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nbranchoutletid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('nbranchid_id')->unsigned();
			$table->integer('outlet_id')->unsigned()->nullable();
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
        Schema::drop('nbranchoutletid');
    }
}
