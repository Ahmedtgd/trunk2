<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('country')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('country')->insert(array (
			0 => array (
				'code' => 'HKG',
				'name' => 'Hong Kong',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array (
				'code' => 'MYS',
				'name' => 'Malaysia',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}

}
