<?php

use Illuminate\Database\Seeder;

class SubcatLevel1Seeder_C1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('subcat_level_1')->truncate();

		$now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('subcat_level_1')->insert(array (
			0 => array (
				'category_id' => 5,
				'name' => 'furniture',
				'description' => 'Furniture',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array (
				'category_id' => 1,
				'name' => 'computer',
				'description' => 'Computers & Laptops',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'category_id' => 1,
				'name' => 'appliance',
				'description' => 'Home Appliances',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'category_id' => 1,
				'name' => 'entertainment',
				'description' => 'Home Entertainment',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'category_id' => 1,
				'name' => 'camera',
				'description' => 'Cameras',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			5 => array (
				'category_id' => 1,
				'name' => 'coffee',
				'description' => 'Coffee Machines',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			6 => array (
				'category_id' => 1,
				'name' => 'bread',
				'description' => 'Bread Makers',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			7 => array (
				'category_id' => 1,
				'name' => 'kettle',
				'description' => 'Eletric Kettles',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			8 => array (
				'category_id' => 1,
				'name' => 'blender',
				'description' => 'Blenders & Grinders',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			9 => array (
				'category_id' => 1,
				'name' => 'juicer',
				'description' => 'Juicers & Fruit Extractors',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			10 => array (
				'category_id' => 1,
				'name' => 'fridge',
				'description' => 'Refridgerators',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			11 => array (
				'category_id' => 1,
				'name' => 'washer',
				'description' => 'Washers & Dryers',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			12 => array (
				'category_id' => 1,
				'name' => 'freezer',
				'description' => 'Freezers',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			13 => array (
				'category_id' => 1,
				'name' => 'skin',
				'description' => 'Skins',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			14 => array (
				'category_id' => 1,
				'name' => 'oven',
				'description' => 'Microwaves & Ovens',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			15 => array (
				'category_id' => 1,
				'name' => 'vacuum',
				'description' => 'Vacuum Cleaners',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			16 => array (
				'category_id' => 1,
				'name' => 'floor',
				'description' => 'Floor Care',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			17 => array (
				'category_id' => 1,
				'name' => 'steamer',
				'description' => 'Garment Steamers',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			18 => array (
				'category_id' => 1,
				'name' => 'iron',
				'description' => 'Irons',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			19 => array (
				'category_id' => 1,
				'name' => 'fan',
				'description' => 'Fans',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			20 => array (
				'category_id' => 1,
				'name' => 'aircond',
				'description' => 'Air Conditioners',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			21 => array (
				'category_id' => 1,
				'name' => 'purifier',
				'description' => 'Air Purifiers',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
    }
}
