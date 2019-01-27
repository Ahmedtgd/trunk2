<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcInvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbc_inv', function(Blueprint $table) {
            $table->increments('id')->unsigned();

			/* detail:invoice = 1:m */
			$table->integer('ocbc_detail_id')->unsigned();

            $table->char('record_type', 2)->default('21');
            $table->char('invoice_details', 75);
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
        Schema::drop('ocbc_inv');
    }
}
