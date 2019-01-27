<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentrequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentrequest', function (Blueprint $table) {
            $table->increments('id');
			// FK to our OWN payment table
            $table->integer('payment_id');

            $table->string('merchant_code', 20);
            $table->integer('ipay88_payment_id');

			// Equivalent to order_id
            $table->string('ref_no', 20);

			// iPay88 also stores money in cents
            $table->integer('amount')->unsigned();

            $table->string('currency', 5);
            $table->string('prod_desc', 100);
            $table->string('user_name', 100);
            $table->string('user_email', 100);
            $table->string('user_contact', 20);
            $table->string('remark', 100);
			$table->enum('lang',array('iso-8859-1','utf-8','gb2312','gd18030','big5'))->default("utf-8");
			$table->string('signature', 100);
			$table->string('response_url', 200);
			$table->string('backend_url', 200);

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
        Schema::drop('paymentrequest');
    }
}
