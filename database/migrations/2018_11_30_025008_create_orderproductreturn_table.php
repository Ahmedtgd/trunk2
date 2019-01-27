<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderproductreturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderproductreturn', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderproductqty_id')->unsigned();

			$table->enum('return_option', ['r','rx','d','dx']);
			$table->integer('return_invoice_id')->unsigned();
			$table->enum('status',
				['active','completed','approved','rejected','return'])->
				default('active');
			$table->text('note');
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
        Schema::drop('orderproductreturn');
    }
}
