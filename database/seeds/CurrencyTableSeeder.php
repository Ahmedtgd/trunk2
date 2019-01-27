<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('currency')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('currency')->insert(array (
			0 => array (
				'code' => 'MYR',
				'name' => 'ringgit',
				'description' => 'Malaysian Ringgit',
				'active' => true,
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array (
				'code' => 'USD',
				'name' => 'dollar',
				'description' => 'US Dollar',
				'active' => false,
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
    }
}
