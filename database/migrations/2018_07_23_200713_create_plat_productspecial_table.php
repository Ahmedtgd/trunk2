<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatProductspecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plat_productspecial', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            /*FK plat_special*/
            $table->integer('special_id')->unsigned();
            $table->enum("status",["active","pending","suspended"]);
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
        Schema::drop('plat_productspecial');
    }
}
