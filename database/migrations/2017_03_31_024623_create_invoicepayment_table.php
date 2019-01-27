<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicepaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('invoicepayment', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('bank_id')->unsigned();
			$table->integer('invoice_id')->unsigned();
			$table->integer('amount')->unsigned();
			$table->date('date_paid');
			$table->text('note');
			$table->enum('method',
				array('cheque','cash','IBG','returned','offset'))->
				default('cash');
 
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
        Schema::drop('invoicepayment');
    }
}
