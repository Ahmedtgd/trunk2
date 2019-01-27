<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* Table to store remarks for Approval */
        Schema::create('remark', function (Blueprint $table) {
            $table->increments('id');

			/* Person who is keying in the remark */
            $table->integer('user_id')->unsigned();

			/* The state when the remark was made */
			$table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected','approved'));

			/* The actual text of the remark */
            $table->text('remark');

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
        Schema::drop('remark');
    }
}
