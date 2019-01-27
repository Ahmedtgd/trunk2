<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();

			/* A nice image for the discount slip, stores in:
			 * public/images/discount/{{$discount->id}}/{{$discount->image}}
			 */
            $table->string('image')->nullable();

			/* Discount in percentage: 30.43% */
            $table->float('discount_percentage')->unsigned();

			/* The date to start this discount promotion */
            $table->timestamp('start_date');

			/* The duration of this promotional discount, in days */
            $table->integer('duration_days')->unsigned();

			/* Code to identity discount slips from a particular batch */
			$table->string('batch_code')->nullable();

			/* The number of discount slips generated for this batch */
			$table->integer('quantity')->unsigned();

            $table->enum('status', ['active','executed','expired']);

			$table->text('remarks')->nullable();

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
        Schema::drop('discount');
    }
}
