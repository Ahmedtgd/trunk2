<?php

use Illuminate\Database\Seeder;

class OpenwishsocialMediaSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('openwishsocial_media')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('openwishsocial_media')->insert(array (
			0 => 
			array (
				'id' => 1,
				'ow_id' => '1',
				'smedia_id' => '1',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 2,
				'ow_id' => '2',
				'smedia_id' => '2',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        2 => 
			array (
				'id' => 3,
				'ow_id' => '2',
				'smedia_id' => '1',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        3 => 
			array (
				'id' => 4,
				'ow_id' => '3',
				'smedia_id' => '3',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        4 => 
			array (
				'id' => 5,
				'ow_id' => '4',
				'smedia_id' => '6',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        5 => 
			array (
				'id' => 6,
				'ow_id' => '5',
				'smedia_id' => '4',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        6 => 
			array (
				'id' => 7,
				'ow_id' => '7',
				'smedia_id' => '6',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        7 => 
			array (
				'id' => 8,
				'ow_id' => '2',
				'smedia_id' => '8',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        8 => 
                            array (
				'id' => 9,
				'ow_id' => '1',
				'smedia_id' => '4',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
                        9 => 
			array (
				'id' => 10,
				'ow_id' => '1',
				'smedia_id' => '1',
                                'deleted_at' => '0',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}

}
