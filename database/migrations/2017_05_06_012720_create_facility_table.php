<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('variable_fee_name');
            $table->integer('token_subscription_fee')->unsigned();
            $table->integer('token_admin_fee')->unsigned();
            $table->integer('packaged_users')->unsigned()->default(5);

			/* Monthly users fee is in TOKEN */
            $table->integer('monthly_users_fee')->unsigned()->default(100);

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
        Schema::drop('sellerfacility');
    }
}
