<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_discount', function (Blueprint $table) {
            $table->increments('id');
			$table->string("name");
			$table->string("description");
            $table->integer("user_id")->unsigned();
			/* Discount value in percentage */
			$table->float("value")->unsigned()->default(0);
			$table->integer("min_discount_amt")->unsigned()->default(0);
			$table->integer("max_discount_amt")->unsigned();
			$table->float("max_discount_pct")->unsigned()->default(99);

			$table->enum("type", ["staff","member","public"]);
			$table->enum("status", ["pending","active","suspended"]);

            $table->timestamps();
            $table->softDeletes();
            $table->engine = "MYISAM";
        });


        Schema::create('opos_servicecharge', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("description");
            /*Owner of record*/
            $table->integer("user_id")->unsigned();
            $table->float("value")->unsigned()->default(0);
            $table->enum("type", ["staff","member","public"])->default("public");
            $table->enum("status", ["pending","active","suspended"]);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('opos_discount');
        Schema::drop('opos_servicecharge');
    }
}
