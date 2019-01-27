<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionldgrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productionldgr', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->default(null);
			$table->float('qty')->unsigned()->default(0);
			// To store Production Decimal
			$table->float('pdecimal')->unsigned()->default(0);
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
        Schema::drop('productionldgr');
    }
}
