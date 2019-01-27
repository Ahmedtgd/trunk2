<?php

use Illuminate\Database\Seeder;

class SubcatLevel1Seeder_C3 extends Seeder
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
 			22 => array (
				'category_id' => 3,
				'name' => 'makeup',
				'description' => 'Makeup',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			23 => array (
				'category_id' => 3,
				'name' => 'skin',
				'description' => 'Skin Care',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			24 => array (
				'category_id' => 3,
				'name' => 'bath',
				'description' => 'Bath & Body',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			25 => array (
				'category_id' => 3,
				'name' => 'hair',
				'description' => 'Hair Care',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			26 => array (
				'category_id' => 3,
				'name' => 'beautytool',
				'description' => 'Beauty Tools',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			27 => array (
				'category_id' => 3,
				'name' => 'shaving',
				'description' => 'Shaving',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			28 => array (
				'category_id' => 3,
				'name' => 'mascara',
				'description' => 'Mascara',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			29 => array (
				'category_id' => 3,
				'name' => 'lipstick',
				'description' => 'Lipstick',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			30 => array (
				'category_id' => 3,
				'name' => 'powder',
				'description' => 'Powder',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			31 => array (
				'category_id' => 3,
				'name' => 'lotion',
				'description' => 'Lotion',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			32 => array (
				'category_id' => 3,
				'name' => 'fragrance',
				'description' => 'Fragrances',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			33 => array (
				'category_id' => 3,
				'name' => 'personal',
				'description' => 'Personal Care',
				'created_at' => $now,
				'updated_at' => $now,
			),

		));
    }
}
