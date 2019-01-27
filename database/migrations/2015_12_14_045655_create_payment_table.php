<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');

			/* This is the price of the order, how much the merchant
			 * would get in their receivable accounts */
            $table->integer('receivable')->unsigned();
            
			/* These are here to let us know whether these people
			 * have been paid or "Generated File" at P18 Consolidator */
			$table->boolean('merchant')->default(false);
			$table->boolean('station')->default(false);
			$table->boolean('mconsultant')->default(false);
			$table->boolean('mprofessional')->default(false);
			$table->boolean('srecruiter')->default(false);
            
			/* Date of which the person in question got paid by bank */
			$table->date('date_paid')->nullable();

			/* This is the commission which OpenSupermall as a platform
			 * would get with each of the merchant's transaction.
			 * This commission is stored as a percentage of the receivable 
                ~Zurez  Obsolete now as osmall_commission has been attached with orderproduct table
             */
            // $table->float('osmall_commission')->unsigned();
            // $table->integer('payment_gateway')->unsigned();
			/* This is the status of the payment for a porder.
			 * executed = consolidated and uploaded payment
			 * 			  instruction to bank
			 * paid 	= confirmation of payment from bank statement
			 * 			  (downloaded and electronically parsed) */
			$table->enum('status', 
				array('pending','awaiting','cancelled','completed',
					'executed','paid'))
					->default('pending');
 
			/* Date which buyer receives the goods: 
			 * Is this relevant? */
            $table->date('consignment')->nullable();

            $table->text('note');

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
        Schema::drop('payment');
    }
}
