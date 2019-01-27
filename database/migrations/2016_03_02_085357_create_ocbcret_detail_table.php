<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcretDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbcret_detail', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            /* header:detail = 1:m */
            $table->integer('ocbcret_header_id')->unsigned();
            $table->char('record_type', 2)->default('02');
            $table->char('receiving_fi_id', 9);
            $table->char('account_number', 20);
            $table->char('instruction', 1)->default('C');
            $table->char('amount', 17);
            $table->char('reference_number', 20);
            $table->char('return_code', 3);
            $table->char('reject_code', 3);
            $table->char('success_indicator', 1);
            $table->char('filler', 2);
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
        Schema::drop('ocbcret_detail');
    }
}
