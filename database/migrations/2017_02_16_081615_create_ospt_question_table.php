<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOspt_questionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ospt_question', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ospt_qcategory_id');
            $table->integer('ospt_qsubcategory_id');
			$table->string('title');
			$table->text('answer');
			$table->enum('status',['published', 'draft']);
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
        Schema::drop('ospt_question');
    }
}
