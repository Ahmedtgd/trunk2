<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdslotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adslot', function (Blueprint $table) {
            $table->increments('id');
            $table->string('placement');
            // from adtarget table
            $table->integer('adtarget_id');
            $table->string('name');
            $table->string('description');
            $table->string('schedule');
            $table->integer('duration')->unsigned();
            $table->integer('price')->unsigned();
            $table->boolean('recurring')->default(false);

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
        Schema::drop('adslot');
    }
}
