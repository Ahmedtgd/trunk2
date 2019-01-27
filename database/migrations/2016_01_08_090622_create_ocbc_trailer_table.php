<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcTrailerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbc_trailer', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->char('record_type', 2)->default('03');
            $table->char('total_count', 6);
            $table->char('total_amount', 19);

			/* Total filler is 453 */
            $table->char('filler1', 255);
            $table->char('filler2', 198);

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
        Schema::drop('ocbc_trailer');
    }
}
