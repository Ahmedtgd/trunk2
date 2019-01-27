<?php

use Illuminate\Database\Seeder;

class OcbcPaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	\DB::table('ocbc_payment_status')->truncate();

        for ($i=0 ; $i <20 ; $i++) {
	        $now = \Carbon\Carbon::now()->toDateTimeString();
	        \DB::table('ocbc_payment_status')->insert(array (
	            $i => array(
	                'id' => $i + 1,
	                'porder_id' => $i + 1,
	                'product_id' => $i + 1,
	                'type' => 'mct',
	                'ocbcgiro_return_id' => 1,
	                'ocbcgiro_reject_id' => 1,
	                'success_indicator' => 1
	            )
	        ));
        }
    }
}
