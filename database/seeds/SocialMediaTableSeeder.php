<?php

use Illuminate\Database\Seeder;

class SocialMediaTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('social_media')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('social_media')->insert(array (
			0 => array (
				'name' => 'Facebook',
				'description' => 'Facebook',
				'url' => 'https://facebook.com',
				'username' => 'xyz',
				'password' => '1234',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array (
				'name' => 'Google',
				'description' => 'test',
				'url' => 'https://google.com',
				'username' => 'xyz',
				'password' => '1234',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'name' => 'Twitter',
				'description' => 'test',
				'url' => '',
				'username' => 'ABC',
				'password' => '123',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'name' => 'LinkedIn',
				'description' => 'test',
				'url' => '',
				'username' => 'ABC',
				'password' => '123',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'name' => 'Instagram',
				'description' => 'txst',
				'url' => '',
				'username' => 'XYZ',
				'password' => '123',
				'created_at' => $now,
				'updated_at' => $now,
			),
            5 => array (
				'name' => 'WeChat',
				'description' => 'test',
				'url' => '',
				'username' => 'ABC',
				'password' => 'XYZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
            6 => array (
				'name' => 'Goole',
				'description' => 'test',
				'url' => '',
				'username' => 'ABC',
				'password' => '1234',
				'created_at' => $now,
				'updated_at' => $now,
			),
            7 => array (
				'name' => 'Facebook',
				'description' => 'test',
				'url' => '',
				'username' => 'ABC',
				'password' => '123',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => array (
				'name' => 'Facebook',
				'description' => 'test',
				'url' => '',
				'username' => 'XYZ',
				'password' => '!@#',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => array (
				'name' => 'Twitter',
				'description' => 'test',
				'url' => '',
				'username' => 'ABC',
				'password' => '$%^',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}

}
