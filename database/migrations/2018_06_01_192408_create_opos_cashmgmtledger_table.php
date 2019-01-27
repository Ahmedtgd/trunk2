<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposCashmgmtledgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_cashmgmtledger', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('terminal_id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->integer('pcreason_id')->unsigned();
			$table->datetime('last_update')->default(null);
			$table->integer('amount');
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
        Schema::drop('opos_cashmgmtledger');
    }
}
