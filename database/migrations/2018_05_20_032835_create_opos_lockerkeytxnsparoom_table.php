<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposLockerkeysparoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_lockerkeytxnsparoom', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('lockerkey_ftype_id')->unsigned();
			$table->integer('sparoom_ftype_id')->unsigned();
            $table->timestamp("sparoom_checkin")->nullable();
            $table->timestamp("sparoom_checkout")->nullable();
            $table->timestamps();
			$table->softDeletes();
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
        Schema::drop('opos_lockerkeytxnsparoom');
    }
}
