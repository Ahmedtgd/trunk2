<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('position_id');
			$table->string('visa_no');
			$table->string('socso_no');
			$table->string('epf_no');
			$table->string('pcb');
			$table->string('monthly_salary');

			/* These fields are obsoleted
			$table->boolean('has_openwish')->default(false);
			$table->boolean('has_smm')->default(false);
			$table->boolean('has_auction')->default(false);
			$table->boolean('has_openbusiness')->default(false);
			*/

			/* This recruiter_id */
			$table->integer('source_user_id')->unsigned();

			$table->integer('bankaccount_id')->unsigned();

			$table->timestamp('active_date');


			/* All payment to employees are via bankaccount 
			$table->integer('payment_method_id')->unsigned();
			$table->string('payment_credential')->nullable();;
			*/

			$table->enum('status',
				array('probation','active','medical',
					'suspended','terminated'));

            /* By Ahmed */
            $table->boolean('payment')->default(false);
            $table->timestamp('payment_at')->nullable();
                                                        
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
        Schema::drop('employee');
    }
}
