<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayslipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('payslip', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('employee_id')->unsigned();
			$table->integer('buyer_id')->unsigned();
			$table->integer('basic_pay');
			$table->integer('bonus');

			$table->softDeletes()->nullable;
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
        Schema::drop('payslip');
    }
}
