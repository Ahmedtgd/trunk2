<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlatProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plat_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("product_id")->unsigned();
            /*Batch Size in which the product is prepared*/
            $table->integer("batch_size")->default(1);
            $table->enum("status",["active","suspended","removed"]);
            $table->timestamps();
            
            $table->softDeletes();
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
        Schema::drop('plat_product');
    }
}
