<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_token', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token')->unique();
            // The number of hits for the token
            $table->integer('count')->default(0);
            $table->integer('user_id')->unsigned();
            // 0->active
            // 1->expired
            $table->enum('status',array('active','expired'));
            /*
            Purpose definition 
            0->email_confirmation
            1->password_reset
            2->email_update
            */
            $table->enum('purpose',array('emailconf','pwdreset','emailupd'));
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
        Schema::drop('security_token');
    }
}
