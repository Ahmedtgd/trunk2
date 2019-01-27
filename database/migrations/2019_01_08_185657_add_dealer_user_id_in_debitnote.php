<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDealerUserIdInDebitnote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
    Schema::table('debitnote', function($table) {
        $table->integer('dealer_user_id');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debitnote', function($table) {
            $table->dropColumn('dealer_user_id');
        });
    }
}
