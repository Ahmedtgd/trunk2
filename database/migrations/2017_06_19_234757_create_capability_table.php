<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('capability', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->softDeletes();
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
        Schema::drop('capability');
    }
}
