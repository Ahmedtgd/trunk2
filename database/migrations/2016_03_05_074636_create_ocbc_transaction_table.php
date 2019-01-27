<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbc_transaction', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('ocbc_header_id')->unsigned();
			$table->integer('ocbcret_header_id')->unsigned();

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
        Schema::drop('ocbc_transaction');
    }
}
