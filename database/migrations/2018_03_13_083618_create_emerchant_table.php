<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emerchant', function (Blueprint $table) {
            $table->increments('id');
            //$table->boolean('is_emerchant')->default(true);
            $table->string('company_name');
            $table->string('business_reg_no');
            $table->string('gst_reg_no');
			$table->string('address_line1');
			$table->string('address_line2');
			$table->string('address_line3');
            $table->integer('country_id')->default(150);
            $table->string('state')->default('Wilayah Persekutuan');
            $table->string('city')->default('Kuala Lumpur');
            $table->string('postcode');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('designation');
			$table->string('mobile_no');
			$table->string('email');
			$table->boolean('registered')->default(false);

  			/* Sequences for serial numbers */
			$table->integer('receipt_no')->unsigned();
			$table->integer('opossum_receipt_no')->unsigned();
			$table->integer('salesmemo_no')->unsigned();
			$table->integer('creditnote_no')->unsigned();
			$table->integer('debitnote_no')->unsigned();
			$table->integer('invoice_no')->unsigned();
			$table->integer('quotation_no')->unsigned();
			$table->integer('consignmentnote_no')->unsigned();
			$table->integer('salesorder_no')->unsigned();
			$table->integer('deliveryorder_no')->unsigned();
			$table->integer('pf_invoice_no')->unsigned(); //Pro-forma Invoice
 

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
        Schema::drop('emerchant');
    }
}
