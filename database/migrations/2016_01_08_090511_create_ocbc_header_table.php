<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbc_header', function(Blueprint $table) {
            $table->increments('id')->unsigned();

			/* header:trailer = 1:1 */
			$table->integer('ocbc_trailer_id')->unsigned();

            $table->char('record_type', 2)->default('01');
            $table->char('tape_id', 3);
            $table->char('branch', 5)->default('00790');
            $table->char('company_cif', 20)->default('A999999');
            $table->char('company_name', 30)->default('Intermedius OpenSupermall');
            $table->char('company_ac_no', 20)->default('7901062119');
            $table->char('instruction', 1)->default('D');
            $table->char('reversal_indicator', 1)->default('N');
            $table->char('crediting_date', 8);
            $table->char('filler1', 40);
            $table->char('customer_ref_no', 16);

			/* Total filler is 334 */
            $table->char('filler2', 255);
            $table->char('filler3', 39);

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
        Schema::drop('ocbc_header');
    }
}
