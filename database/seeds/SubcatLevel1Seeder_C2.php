<?php

use Illuminate\Database\Seeder;

class SubcatLevel1Seeder_C2 extends Seeder
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
				'category_id' => 2,
				'name' => 'women',
				'description' => "Women's Clothing",
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array (
				'category_id' => 2,
				'name' => 'men',
				'description' => "Men's Clothing",
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'category_id' => 2,
				'name' => 'children',
				'description' => "Children's Clothing",
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'category_id' => 2,
				'name' => 'baby',
				'description' => "Baby's Clothing",
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'category_id' => 2,
				'name' => 'sport',
				'description' => "Sports Wear",
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => array (
				'category_id' => 2,
				'name' => 'lingerie',
				'description' => "Lingerie",
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => array (
				'category_id' => 2,
				'name' => 'wedding',
				'description' => "Wedding Apparels & Accessories",
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => array (
				'category_id' => 2,
				'name' => 'costume',
				'description' => "Costumes",
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => array (
				'category_id' => 2,
				'name' => 'hat',
				'description' => "Hats",
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => array (
				'category_id' => 2,
				'name' => 'jewellry',
				'description' => "Jewellry",
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => array (
				'category_id' => 2,
				'name' => 'scarf',
				'description' => "Scarf",
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => array (
				'category_id' => 2,
				'name' => 'glove',
				'description' => "Gloves",
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => array (
				'category_id' => 2,
				'name' => 'winter',
				'description' => "Winter Wear",
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => array (
				'category_id' => 2,
				'name' => 'jeans',
				'description' => "Jeans",
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => array (
				'category_id' => 2,
				'name' => 'optical',
				'description' => "Optical Wear",
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => array (
				'category_id' => 2,
				'name' => 'foot',
				'description' => "Foot Wear",
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => array (
				'category_id' => 2,
				'name' => 'bag',
				'description' => "Bags & Leatherwear",
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => array (
				'category_id' => 2,
				'name' => 'watch',
				'description' => "Watches",
				'created_at' => $now,
				'updated_at' => $now,
			),
 			18 => array (
				'category_id' => 2,
				'name' => 'wallet',
				'description' => "Wallets",
				'created_at' => $now,
				'updated_at' => $now,
			),
  			19 => array (
				'category_id' => 2,
				'name' => 'accessory',
				'description' => "Accessories",
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
    }
}
