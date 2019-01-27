<?php

use Illuminate\Database\Seeder;

class ncountryid_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  		\DB::table('ncountryid')->truncate();

		/* New ID Mapping table for Country; 2 digits */
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('ncountryid')->insert(array(
			0 => array (
				'country_id' => 150,	// MYS
				'ncountry_id' => '001',	// MYS
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'country_id' => 93,		// HKG
				'ncountry_id' => '002',		// HKG
				'created_at' => $now,
				'updated_at' => $now,
			), 
    	)); 
    }
}
