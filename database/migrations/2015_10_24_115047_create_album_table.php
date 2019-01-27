<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* Album is different from Merchant, in particular relationship
		 * betwen album:product and merchant:product is very different.
		 *
		 * merchant:product encompasses every single product which the
		 * merchant stocks and sells.
		 *
		 * album:product only has the products which the merchant has
		 * shortlisted to be potentially displayed at the shopfront.
		 */

        Schema::create('album', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->unsigned();
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
        Schema::drop('album');
    }
}
