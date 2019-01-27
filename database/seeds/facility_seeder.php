<?php

use Illuminate\Database\Seeder;

class facility_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		\DB::table('facility')->truncate();
		$now = \Carbon\Carbon::now()->toDateTimeString();

		\DB::table('facility')->insert(array(
			0 => array (
				'name' => 'term',
				'description' => 'Credit Term',
				'token_subscription_fee' => 10000,		//Token, NOT money
				'token_admin_fee' => 2,					//Token, NOT money
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'name' => 'vmi',
				'description' => 'Vendor Manage Inventory',
				'token_subscription_fee' => 20000,		//Token, NOT money
				'token_admin_fee' => 2,					//Token, NOT money
				'created_at' => $now,
				'updated_at' => $now,
			), 
		));
    }
}
