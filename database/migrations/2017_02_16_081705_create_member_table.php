<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->string('email')->unique()->nullable();
			$table->string('name');
			$table->string('mobile');
			$table->integer('company_id')->unsigned();
			$table->integer('companymembersegment_id')->unsigned();

			/* Text to be tied to a staff commission definition */
			$table->string('commtext');

			/* Email is only unique to a company as member can be tagged by 
			 * many companies */
			//$table->unique(['email','company_id','type']);

			$table->integer('user_id')->unsigned();
			$table->integer('recruiter_id')->unsigned();

			/**** This is the user ID for generic use ****/
			$table->integer('owner_id')->unsigned();
			
			$table->enum('type',array('member','customer'))->default('member');

			$table->enum('member_status',array('not exists','tagged','exists',
				'active','pending','suspended'));

			$table->enum('status',array('pending','active','dormant',
				'barred','suspended','rejected','closed','terminated'))->
				default('pending');

			$table->string('member_no');
			/* This is to store pop up from Actions column */
			$table->string('action');
			$table->string('stage');
			$table->text('remark');

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
        Schema::drop('member');
    }
}
