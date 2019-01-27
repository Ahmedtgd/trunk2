<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();

            $table->string('image');
            $table->string('bg_color')->default('#ffffff');
            $table->string('font_family')->default('sans-serif, arial');
            $table->string('font_color')->default('#000000');
            $table->string('font_style')->default('normal');
            $table->tinyinteger('font_size')->default(12);

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
        Schema::drop('theme');
    }
}
