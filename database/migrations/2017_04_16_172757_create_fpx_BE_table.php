<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFpxBETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fpx_BE', function (Blueprint $table) {
            $table->increments('id');
			/* 1. Indicate message type: BE */
			$table->string('fpx_msgType',2)->default('BE');

			/* 2. Indicate business model: 01-B2C, 02-B2B1, 03-B2B2 */
			$table->tinyInteger('fpx_msgToken')->unsigned();

			/* 3. Exchange ID - provided by FPX */
			$table->string('fpx_sellerExId',10);

			/* 4. Version number: Default 6.0 */
			$table->tinyInteger('fpx_version')->default(6);

			/* 5. Checksum value. Hold message signature */
			$table->string('fpx_checkSum');

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
        Schema::drop('fpx_BE');
    }
}
