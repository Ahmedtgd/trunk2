<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuntingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bunting', function (Blueprint $table) {
            $table->increments('id');
			/* album:bunting = 1:m */
            $table->integer('album_id')->unsigned();

			/* Path to where the bunting image resides */
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
        Schema::drop('bunting');
    }
}
