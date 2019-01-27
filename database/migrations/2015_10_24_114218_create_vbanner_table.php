<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVbannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vbanner', function (Blueprint $table) {
            $table->increments('id');
			/* album:vbanner = 1:m */
			$table->integer('album_id')->unsigned();

			/* Name of video clip */
			$table->string('image');
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
        Schema::drop('vbanner');
    }
}
