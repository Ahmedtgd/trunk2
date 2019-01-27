<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNvAuthApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('nv_access_token_req', function (Blueprint $table) {
            $table->increments('id');
			$table->string('client_id');
			$table->string('client_secret');
			$table->string('grant_type');
            $table->softDeletes();
            $table->timestamps();
            $table->engine = "MYISAM";
        });

        Schema::create('nv_access_token_resp', function (Blueprint $table) {
            $table->increments('id');
			$table->string('access_token');
			$table->string('status_code');
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
        Schema::drop('nv_access_token_req');
        Schema::drop('nv_access_token_resp');
    }
}
