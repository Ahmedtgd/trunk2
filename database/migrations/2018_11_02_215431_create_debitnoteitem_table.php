<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitnoteitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debitnoteitem', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('debitnote_id')->unsigned;
			$table->string('debitnoteitem_no');
			$table->string('description');
			$table->integer('total')->unsigned;
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
        Schema::drop('debitnoteitem');
    }
}