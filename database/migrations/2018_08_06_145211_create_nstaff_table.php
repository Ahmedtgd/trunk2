<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNstaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nstaff', function (Blueprint $table) {
            $table->increments('id');
            // Can get member.user_id, member.email
            $table->string('member_id');

            // For secondary login page
            $table->string('nickname');		// secondary username
            $table->string('login_name');	// secondary password (6 digits)


            $table->string('name');
            $table->string('address_line1');
            $table->string('address_line2');
            $table->string('address_line3');
            $table->integer('country_id')->default(150);
            $table->integer('state_id');
            $table->integer('city_id');
            $table->string('postcode');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('designation_id');
            $table->string('mobile_no');
            $table->string('alt_email');
            $table->boolean('registered')->default(false);

            $table->softDeletes();
            $table->engine = 'MYISAM';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nstaff');
    }
}
