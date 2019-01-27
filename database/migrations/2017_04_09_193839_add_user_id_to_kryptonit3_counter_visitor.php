<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToKryptonit3CounterVisitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kryptonit3_counter_visitor', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->after('id');
        });

        Schema::table('kryptonit3_counter_visitor', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kryptonit3_counter_visitor', function (Blueprint $table) {
            //
        });
    }
}
