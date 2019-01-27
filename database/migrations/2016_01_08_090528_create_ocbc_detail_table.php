<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbc_detail', function(Blueprint $table) {
            $table->increments('id')->unsigned();

			/* header:detail = 1:m */
            $table->integer('ocbc_header_id')->unsigned();

            $table->char('record_type', 2)->default('02');
            $table->char('account_number', 20);
            $table->char('amount', 17);
            $table->char('instruction', 1)->default('C');
            $table->char('new_ic_number', 12);
            $table->char('old_ic_no', 8);
            $table->char('txn_description', 20);
            $table->char('business_registration_no', 20);
            $table->char('reference_number', 20);
            $table->char('receiving_fi_id', 9);
            $table->char('beneficiary_name', 22);
            $table->char('passport_no', 20);
            $table->char('send_advice_via', 1)->default('E');
            $table->char('email', 50);
            $table->char('fax_no', 24);
            $table->char('require_id_check', 1)->default('N');
            $table->char('filler', 233);
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
        Schema::drop('ocbc_detail');
    }
}
