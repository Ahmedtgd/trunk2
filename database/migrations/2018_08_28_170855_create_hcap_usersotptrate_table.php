<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapUsersotptrateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_usersotptrate', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			// FK to the hcap_otptrate table
			$table->integer('otptrate_id')->unsigned();

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
        Schema::drop('hcap_usersotptrate');
    }
}
