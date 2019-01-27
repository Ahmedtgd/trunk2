<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFsectionATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fsection_a', function (Blueprint $table) {
            $table->increments('id');
			$table->text('about_us');
			$table->text('private_policy');
			$table->text('how_to_buy');
			$table->text('how_to_return');
			$table->text('how_to_sell');
			$table->text('terms_and_conditions');

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
        Schema::drop('fsection_a');
    }
}
