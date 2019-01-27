<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJcTprequestAck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jc_tprequest_ack', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jc_topup_request_id');
            $table->string('message');
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
        Schema::drop('jc_tprequest_ack');
    }
}
