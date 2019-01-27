<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

/*
	Malaysia's country_code = 'MYS'

    MY01: Johor
    MY02: Kedah
    MY03: Kelantan
    MY04: Melaka State, Malaysia
    MY05: Negeri Sembilan
    MY06: Pahang
    MY07: Perak
    MY08: Perlis
    MY09: Pulau Pinang State, Malaysia
    MY11: Sarawak
    MY12: Selangor
    MY13: Terengganu
    MY14: Kuala Lumpur
    //MY15: Labuan Federal Territory, Malaysia
    MY16: Sabah
    //MY17: Putrajaya
*/




    public function up()
    {
        Schema::create('state', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('code',4);
			$table->char('country_code',3);
			$table->integer('statecountry_id')->unsigned();
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
        Schema::drop('state');
    }
}
