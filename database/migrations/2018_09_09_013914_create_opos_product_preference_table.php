<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposProductPreferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_productpreference', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('terminal_id')->unsigned();
            /*Chars that can be localised for a product*/
            $table->string('name');
            $table->string('photo_1');
            $table->string('thumb_photo');
            $table->integer('local_price')->unsigned();
            $table->boolean('price_keyin')->default(false);
            $table->enum('status',['hide','show']);
            
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
        Schema::drop('opos_productpreference');
    }
}
