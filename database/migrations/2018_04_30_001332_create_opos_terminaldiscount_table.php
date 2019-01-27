<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposTerminaldiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_terminaldiscount', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('terminal_id')->unsigned();
            $table->integer('discount_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
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
        Schema::drop('opos_terminaldiscount');
    }
}
