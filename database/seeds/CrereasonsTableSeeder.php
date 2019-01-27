<?php
// Created by Syed Salman Ali (salman.falcon@gmail.com)

use Illuminate\Database\Seeder;

class CrereasonsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::table('crereasons')->insert([
			0 => ['area' => 'delivery', 'reason_text' => 'wrong product'],
			1 => ['area' => 'quality', 'reason_text' => 'damanged product'],
			2 => ['area' => 'quality', 'reason_text' => 'defective'],
			3 => ['area' => 'quality', 'reason_text' => 'production condition'],
			4 => ['area' => 'delivery', 'reason_text' => 'parts missing'],
			5 => ['area' => 'website', 'reason_text' => 'incorrect information'],
			6 => ['area' => 'product', 'reason_text' => 'does not fit'],
			7 => ['area' => 'customer', 'reason_text' => 'change of mind'],
			8 => ['area' => NULL, 'reason_text' => 'not as expected'],
		]);
	}

}
