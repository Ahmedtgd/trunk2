<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcgiroRejcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbcgiro_reject', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->char('code', 3);
            $table->string('description', 255);
            $table->string('remarks', 255);

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
       Schema::drop('ocbcgiro_reject');
    }
}
