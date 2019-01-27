<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCacctnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cacctno', function (Blueprint $table) {
            $table->increments('id');
			$table->string('acctno');

            /* Simple text for reference.
			 * Not to be confused with internal company ~Zurez */
			$table->string('company');

            /*Obsolete but still in use*/
            $table->integer("location_id")->unsigned();
            $table->integer("merchant_id")->unsigned();
            $table->integer("company_id")->unsigned();

            /**/
            /*Merchant's User Id*/
			$table->integer('user_id')->unsigned();
			$table->softDeletes();
            $table->timestamps();
			$table->engine = "MYISAM";
        });

        /* cacctno:locationcacctno=1:m */
        Schema::create('locationcacctno', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cacctno_id')->unsigned();
            $table->integer('location_id')->unsigned();
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
        Schema::drop('cacctno');
        Schema::drop('locationcacctno');
    }
}
