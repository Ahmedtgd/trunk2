<?php

use Illuminate\Database\Seeder;

class SubcatLevel1Seeder_C10 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('subcat_level_1')->insert(array (
			0 => array (
				'category_id' => 15,
				'name' => 'security',
				'description' => "Security Services",
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array (
				'category_id' => 15,
				'name' => 'fortune',
				'description' => "Fortune Telling",
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'category_id' => 15,
				'name' => 'autorepair',
				'description' => "Automotive Repair",
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'category_id' => 15,
				'name' => 'autocare',
				'description' => "Automotive Care",
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'category_id' => 15,
				'name' => 'insurance',
				'description' => "General Insurance",
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => array (
				'category_id' => 15,
				'name' => 'pet',
				'description' => "Pets Grooming & Obedience",
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => array (
				'category_id' => 15,
				'name' => 'topup',
				'description' => "Mobile Top-Up",
				'created_at' => $now,
				'updated_at' => $now,
			),

		));
    }
}
