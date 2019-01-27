<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersegmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membersegment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('segment_id');
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
		Schema::drop('membersegment');
    }
}
