<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorderpaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porderpayment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_number');
            $table->integer('porder_id')->unsigned();
            $table->string('email');
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
        Schema::drop('porderpayment');
    }
}
