<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposPettycashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_pettycash', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('terminal_id')->unsigned();
			$table->enum('mode',['in','out']);
			$table->integer('staff_user_id')->unsigned();
			$table->integer('pcreason_id')->unsigned();
			$table->integer('amount')->unsigned();

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
        Schema::drop('opos_pettycash');
    }
}
