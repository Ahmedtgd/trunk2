<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlet', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('description');

			/* station:outlet = 1:m */
			$table->integer('station_id')->unsigned();

			/* Station
			 * Consolidation
			 * Installation
			 * Direct 
			 * Internal Consumption */
			$table->enum('type', array('station','consolidation','install',
				'direct', 'internal'))->default('station');

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
        Schema::drop('outlet');
    }
}
