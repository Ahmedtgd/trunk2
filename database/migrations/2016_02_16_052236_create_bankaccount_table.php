<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankaccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Each records represents a user's account with a bank */

        Schema::create('bankaccount', function (Blueprint $table) {
            $table->increments('id');

            /* Which bank do these accounts are from? */
            $table->integer('bank_id')->unsigned()->nullable();

            $table->string('account_name1')->nullable();
            $table->string('account_number1')->nullable();
            $table->string('account_name2')->nullable();
            $table->string('account_number2')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'MyISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bankaccount');
    }
}
