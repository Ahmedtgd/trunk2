<?php

use Illuminate\Database\Seeder;

class nstateid_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   		\DB::table('nstateid')->truncate();

		/* New ID Mapping table for State; 2 digits */
        $now = \Carbon\Carbon::now()->toDateTimeString();
		$states = DB::table('state')->where('country_code','MYS')->get();
		$id = 1;
		foreach($states as $state){
			DB::table('nstateid')->
				insert([
					'state_id'=>$state->id,
					'nstate_id'=>'001' . str_pad($id,2,'0',STR_PAD_LEFT),
					'created_at' => $now,
					'updated_at' => $now
				]);
			$id++;
		}
        /*\DB::table('nstateid')->insert(array(
			0 => array (
				'nstate_id' => 1,		// MYS
				'ncountry_id' => 1,		// MYS
				'state_id' => 1,		// Johor
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 2,		// Kedah
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			2 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 3,		// Kelantan
				'created_at' => $now,
				'updated_at' => $now,
			),  
 			3 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 4,		// Melaka
				'created_at' => $now,
				'updated_at' => $now,
			),
 			4 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 5,		// Negeri Sembilan
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			5 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 6,		// Pahang
				'created_at' => $now,
				'updated_at' => $now,
			),   
 			6 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 7,		// Perak
				'created_at' => $now,
				'updated_at' => $now,
			),
 			7 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 8,		// Perlis
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			8 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 9,		// PUlau Pinang
				'created_at' => $now,
				'updated_at' => $now,
			),  
 			9 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 11,		// Sarawak
				'created_at' => $now,
				'updated_at' => $now,
			),
 			10 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 12,		// Selangor
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			11 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 13,		// Terengganu 
				'created_at' => $now,
				'updated_at' => $now,
			),    
  			12 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 14,		// Wilayah Persekutuan
				'created_at' => $now,
				'updated_at' => $now,
			),
 			13 => array (
				'ncountry_id' => 1,		// MYS
				'state_id' => 16,		// Sabah
				'created_at' => $now,
				'updated_at' => $now,
			), 
    	));*/  
    }
}
