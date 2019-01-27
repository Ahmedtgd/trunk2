<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePposporderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppos_order', function (Blueprint $table) {
            $table->increments('id');
            $table->enum("paymentmode",["cash","card"])->default("cash");
            $table->integer('user_id')->unsigned();
            $table->enum("status",["pending","completed","failed","cancelled"])->default("pending");
            /*Phone number & email of the customer. to notify him*/
            $table->integer("phone_no");
            $table->integer("email");
            $table->string('description')->nullable();
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
        Schema::drop('ppos_order');
    }
}
