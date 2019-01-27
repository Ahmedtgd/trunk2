<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposTerminalusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_terminalusers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('terminal_id')->unsigned();
            $table->integer('user_id')->unsigned();
			$table->enum('status', ['pending','active','suspended'])->
				default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opos_terminalusers');
    }
}
