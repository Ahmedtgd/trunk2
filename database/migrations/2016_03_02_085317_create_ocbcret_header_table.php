<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcretHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbcret_header', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('ocbcret_trailer_id')->unsigned();
            $table->char('record_type', 2)->default('01');
            $table->char('company_ac_no', 20)->default('7901062119');
            $table->char('value_date', 8);
            $table->char('filler', 47);

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
        Schema::drop('ocbcret_header');
    }
}
