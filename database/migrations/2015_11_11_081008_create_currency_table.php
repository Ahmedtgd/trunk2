<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('code', 3)->default('myr');

			/* Exchange rate to convert to MYR1:
			 * MYR1 -> USD?
			 * MYR1 -> RMB? */
            $table->float('exchange_rate');

            $table->string('name');
            $table->string('description');
            $table->boolean('active');
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
        Schema::drop('currency');
    }
}
