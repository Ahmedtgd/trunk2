<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_leave', function (Blueprint $table) {
            $table->increments('id');
			// The type of leave
			$table->integer('leavetype_id')->unsigned();

			// The staff who had applied for the leave
			$table->integer('staff_user_id')->unsigned();

			// The manager who approved the leave
			$table->integer('approver_user_id')->unsigned();
			$table->dateTime('approval_dt');
			$table->enum('status',
				['pending','approved','rejected','expired'])->
				default('pending');
			$table->string('remarks');
            $table->softDeletes();
            $table->timestamps();
			$table->engine = "MYISAM";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hcap_leave');
    }
}
