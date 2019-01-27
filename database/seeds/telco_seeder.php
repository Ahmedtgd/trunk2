<?php

use Illuminate\Database\Seeder;

class telco_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 		\DB::table('telco')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('telco')->insert(array(
			0 => array (
				'name' => 'hotlink',
				'code' => 'mx',
				'description' => 'Hotlink MX',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'name' => 'celcom',
				'code' => 'cc',
				'description' => 'Celcom CC',
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			2 => array (
				'name' => 'digi',
				'code' => 'dg',
				'description' => 'DiGi DG',
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			3 => array (
				'name' => 'umobile',
				'code' => 'um',
				'description' => 'Umobile UM',
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			4 => array (
				'name' => 'tunetalk',
				'code' => 'tune',
				'description' => 'Tunetalk TUNE',
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			6 => array (
				'name' => 'merchantrade',
				'code' => 'mt',
				'description' => 'Merchantrade MT',
				'created_at' => $now,
				'updated_at' => $now,
			), 
		));
 
    }
}
