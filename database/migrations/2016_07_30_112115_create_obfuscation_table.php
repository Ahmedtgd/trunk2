<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObfuscationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('obfuscate',function(Blueprint $table){
            $table->increments('id')->unsigned();
            // Url to be shortened/obfuscated. Is not unique
            $table->string('url');
            // ShortenedUrl. Must be unique
            $table->string('surl')->unique();
            // The user id for whom the url was create
            $table->integer('user_id')->unsigned();
            // Referrer defaulted generic
            $table->enum('referrer',array('smm','hyper','autolink','owish','retail','b2b','generic'))->default('generic');
            // Referrer id . If generic use 0
            $table->integer('referrer_id');
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
        Schema::drop('obfuscate');
    }
}
