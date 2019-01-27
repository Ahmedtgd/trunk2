<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditnoteitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditnoteitem', function (Blueprint $table) {
            $table->increments('id');
 			$table->integer('creditnote_id')->unsigned();
 			$table->string('creditnoteitem_no');
			$table->string('description');
			/* This stores the monetary value in cents in the DB */
			$table->integer('total')->unsigned();
			$table->enum('status',
				['active','pending','approved','rejected'])->
				default('active');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('creditnoteitem');
    }
}
