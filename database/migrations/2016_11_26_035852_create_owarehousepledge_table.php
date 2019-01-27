<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwarehousepledgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owarehousepledge', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('owarehouse_id')->unsigned();
			$table->integer('user_id')->unsigned();
            $table->integer('porder_id')->unsigned();
			$table->integer('pledged_qty')->unsigned();
			$table->enum('status',['hyper','executed'])->default('hyper');
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
        Schema::drop('owarehousepledge');
    }
}
