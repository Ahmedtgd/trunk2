<?php

use Illuminate\Database\Seeder;

class OutletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('outlet')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('outlet')->insert(array (
			0 => array (
				'name' => 'mini_market',
				'description' => 'Mini Market',
				'station_id' => 1,
				'type' => 'station',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'name' => 'oriental_shop',
				'description' => 'Oriental Shop',
				'station_id' => 2,
				'type' => 'station',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			2 => array (
				'name' => 'pharmacy',
				'description' => 'Pharmacy',
				'station_id' => 3,
				'type' => 'station',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			3 => array (
				'name' => 'supermarket',
				'description' => 'Supermarket',
				'station_id' => 4,
				'type' => 'station',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			4 => array (
				'name' => 'hypermarket',
				'description' => 'Hypermarket',
				'station_id' => 5,
				'type' => 'station',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			), 
 
		));
    }
}
