<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		\DB::table('language')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('language')->insert(array (
			0 => array (
				'code' => 'en',
				'name' => 'english',
				'description' => 'English',
				'created_at' => $now,
				'updated_at' => $now,
			),
/*
			1 => array (
				'code' => 'zh',
				'name' => 'schinese',
				'description' => 'Simplified Chinese',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'code' => 'zf',
				'name' => 'tchinese',
				'description' => 'Traditional Chinese',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'code' => 'ms',
				'name' => 'malay',
				'description' => 'Malay',
				'created_at' => $now,
				'updated_at' => $now,
			),
*/
		));
    }
}
