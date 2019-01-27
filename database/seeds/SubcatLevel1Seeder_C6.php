<?php

use Illuminate\Database\Seeder;

class SubcatLevel1Seeder_C6 extends Seeder
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
			1 => array (
				'category_id' => 6,
				'name' => 'sofa',
				'description' => "Sofa",
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'category_id' => 6,
				'name' => 'chair',
				'description' => "Chairs",
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'category_id' => 6,
				'name' => 'table',
				'description' => "Tables",
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'category_id' => 6,
				'name' => 'officechair',
				'description' => "Office Chairs",
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => array (
				'category_id' => 6,
				'name' => 'officetable',
				'description' => "Office Tables",
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => array (
				'category_id' => 6,
				'name' => 'outdoor',
				'description' => "Outdoor Furniture",
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => array (
				'category_id' => 6,
				'name' => 'bed',
				'description' => "Beds",
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => array (
				'category_id' => 6,
				'name' => 'lamp',
				'description' => "Lamps",
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => array (
				'category_id' => 6,
				'name' => 'carpet',
				'description' => "Carpets",
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => array (
				'category_id' => 6,
				'name' => 'kitchen',
				'description' => "Kitchen Ware",
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => array (
				'category_id' => 6,
				'name' => 'pest',
				'description' => "Pest Repellent",
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => array (
				'category_id' => 6,
				'name' => 'household_detergent',
				'description' => "Household Detergent",
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
    }
}
