<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRackproductledgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rackproductledger', function (Blueprint $table) {
            $table->increments('id');
            /*FK to StockReportProductID && SalesMemoProductID*/
            $table->integer('transaction_id')->unsigned();
            $table->integer('rack_id')->unsigned();
            $table->enum('type',['tin','tout','smemo']);
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
        Schema::drop('rackproductledger');
    }
}
