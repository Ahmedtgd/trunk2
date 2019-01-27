<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposFtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_ftype', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fnumber')->unsigned;
            $table->integer('location_id')->unsigned;
            $table->integer('terminal_id')->unsigned;
            $table->string('name');			//optional
            $table->string('description');	//optional
			$table->enum('ftype',['lockerkey','sparoom','hotelroom','car','table'])->default(null);

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
        Schema::drop('opos_ftype');
    }
}
