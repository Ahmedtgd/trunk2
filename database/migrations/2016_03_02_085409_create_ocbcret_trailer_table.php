<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcretTrailerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbcret_trailer', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->char('record_type', 2)->default('03');
            $table->char('accepted_count', 6);
            $table->char('accepted_amount', 19);
            $table->char('reject_count', 6);
            $table->char('reject_amount', 19);
            $table->char('returned_count', 6);
            $table->char('returned_amount', 19);
            $table->char('total_count', 6);
            $table->char('total_amount', 19);

            $table->char('filler', 3);

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
        Schema::drop('ocbcret_trailer');
    }
}
