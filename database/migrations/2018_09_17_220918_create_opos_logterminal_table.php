<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposLogterminalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_logterminal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('terminal_id')->unsigned();
            $table->timestamp('start_work');
            $table->timestamp('eod');
            $table->enum('type',['manual','natural'])->default('natural');
            // Sale for the business day in cents
            $table->integer('today_branch_sales')->default(0);
            $table->integer('today_sales')->default(0);
            $table->integer('today_sst')->default(0);
            $table->integer('today_servicecharge')->default(0);
            $table->integer('today_cash')->default(0);
            $table->integer('today_creditcard')->default(0);
            $table->integer('today_point')->default(0);
            $table->integer('monthly_sales')->default(0);
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
        Schema::drop('opos_logterminal');
    }
}
