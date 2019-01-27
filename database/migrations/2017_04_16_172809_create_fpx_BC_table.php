<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFpxBCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fpx_BC', function (Blueprint $table) {
            $table->increments('id');

			/* 1. Indicate message type: BC */
			$table->string('fpx_msgType',2)->default('BC');

 			/* 2. Indicate business model: 01-B2C, 02-B2B1, 03-B2B2 */
			$table->tinyInteger('fpx_msgToken')->unsigned();

			/* 3. Exchange ID - provided by FPX */
			$table->string('fpx_sellerExId',10);

			/* 4. FPX Bank ID - Bank Status: Active(A)/Blocked(B)
			 * e.g. TESTBANK10-A, TESTBANK11-B */
			$table->text('fpx_bankList');

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
        Schema::drop('fpx_BC');
    }
}
