<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAprsectionremarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aprchecklistremark', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aprchecklist_id')->unsigned();
            $table->integer('remark_id')->unsigned();
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
        Schema::drop('aprchecklistremark');
    }
}
