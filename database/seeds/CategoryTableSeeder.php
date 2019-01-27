<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('category')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('category')->insert(array(
			0 => array (
				'name' => 'electronics',
				'description' => 'Electronics',
				'logo_white'=>'electronics.png',
				'logo_green'=>'electronics.png',
				'floor'=>1,
				'color'=>'#185a72',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'name' => 'fashion',
				'description' => 'Fashion',
				'logo_white'=>'fashion.png',
				'logo_green'=>'fashion.png',
				'floor'=>2,
				'color'=>'#b97880',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'name' => 'beauty',
				'description' => "Beauty & Cosmetics",
				'logo_white'=>'beauty.png',
				'logo_green'=>'beauty.png',
				'floor'=>3,
				'color'=>'#b06681',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'name' => 'health',
				'description' => 'Health & Medical',
				'logo_white'=>'',
				'logo_green'=>'',
				'floor'=>4,
				'color'=>'#801c36',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'name' => 'house',
				'description' => 'Household & Groceries',
				'logo_white'=>'',
				'logo_green'=>'',
				'floor'=>5,
				'color'=>'#5d9742',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => array (
				'name' => 'home',
				'description' => 'Home & Furniture',
				'logo_white'=>'home.png',
				'logo_green'=>'home.png',
				'floor'=>6,
				'color'=>'#018385',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			6 => array (
				'name' => 'toys',
				'description' => 'Toys & Sports',
				'logo_white'=>'',
				'logo_green'=>'',
				'floor'=>7,
				'color'=>'#668f93',
				'created_at' => $now,
				'updated_at' => $now,
			), 
			7 => array (
				'name' => 'automotive',
				'description' => 'Automotive & Industrial',
				'logo_white'=>'automotive.png',
				'logo_green'=>'automotive.png',
				'floor'=>8,
				'color'=>'#668f93',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			8 => array (
				'name' => 'cafe',
				'description' => 'Cafe & Dining',
				'logo_white'=>'',
				'logo_green'=>'',
				'floor'=>9,
				'color'=>'#36808d',
				'created_at' => $now,
				'updated_at' => $now,
			), 
			9 => array (
				'name' => 'service',
				'description' => 'General Services',
				'logo_white'=>'service.png',
				'logo_green'=>'service.png',
				'floor'=>10,
				'color'=>'#36808d',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}
}
