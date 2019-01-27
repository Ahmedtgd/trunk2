<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesmemoproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('salesmemoproduct', function(Blueprint $table) {
			$table->increments('id')->unsigned();

			/* This is the price is product's price*/
			$table->integer('product_id')->unsigned();
			$table->integer('salesmemo_id')->unsigned();
			$table->integer('quantity')->unsigned();
			$table->integer('price')->unsigned();
            $table->enum('status',['active','pending','failed','expired','cancelled','removed'])->default("pending");
			$table->softDeletes();

			/* Order received = created_at */
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
        Schema::drop('salesmemoproduct');
    }
}
