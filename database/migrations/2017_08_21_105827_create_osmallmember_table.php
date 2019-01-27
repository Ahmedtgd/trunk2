<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOsmallmemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osmallmember', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->string('email')->unique();
			$table->string('name');
			$table->string('mobile');

			/* Email is only unique to a company as member can be tagged by 
			 * many companies */
			$table->unique(['email']);


			$table->integer('user_id')->unsigned();
			$table->integer('osmallmembersegment_id')->unsigned();
			$table->integer('recruiter_id')->unsigned();
			
			$table->enum('type',array('member','customer'))->default('member');

			$table->enum('status',array('pending','active','dormant',
				'barred','suspended','rejected','closed','terminated'))->
				default('pending');

			$table->enum('member_status',array('not exists','tagged','exists',
				'active','pending','suspended'));

			/* This has been obsoleted by: roles.memberlist boolean
			 * If true, then that role is available as an option.
			 * Furthermore: member:roles = 1:m => memberroles
			$table->enum('role',array('employee','benefit'));
			 */
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
        Schema::drop('osmallmember');
    }
}
