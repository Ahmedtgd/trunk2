<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signboard', function (Blueprint $table) {
            $table->increments('id');

			/* OBSOLETED: DO NOT USE */
            $table->integer('album_id')->unsigned();

			/* merchant:oshop  = 1:m -> merchantoshop pivot
			   oshop:signboard = 1:1 */
            $table->integer('oshop_id')->unsigned();

			$table->boolean('active')->default(false);
			/* Name of the signboard image file */
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
        Schema::drop('signboard');
    }
}
