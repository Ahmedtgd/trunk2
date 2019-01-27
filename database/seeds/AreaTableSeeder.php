<?php

use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    //\DB::table('address')->truncate();
    $now = \Carbon\Carbon::now()->toDateTimeString();
    \DB::table('area')->insert(array (
		0 => array(
        'name' => 'Area1',
        'description' => 'Area1',	
        'postcode' => 1,	
        'city_id' => 1,
        'created_at'  => $now,
        'updated_at'  => $now
        ),
        1 => array(
        'name' => 'Area2',
        'description' => 'Area2',	
        'postcode' => 2,	
        'city_id' => 1,
        'created_at'  => $now,
        'updated_at'  => $now
        ),
        2 => array(
        'name' => 'Area3',
        'description' => 'Area3',	
        'postcode' => 3,	
        'city_id' => 1,
        'created_at'  => $now,
        'updated_at'  => $now
        ),
        3 => array(
        'name' => 'Area4',
        'description' => 'Area4',	
        'postcode' => 4,	
        'city_id' => 2,
        'created_at'  => $now,
        'updated_at'  => $now
        ),
        4 => array(
        'name' => 'Area5',
        'description' => 'Area5',	
        'postcode' => 5,	
        'city_id' => 2,
        'created_at'  => $now,
        'updated_at'  => $now
        ),
        5 => array(
        'name' => 'Area6',
        'description' => 'Area6',	
        'postcode' => 6,	
        'city_id' => 2,
        'created_at'  => $now,
        'updated_at'  => $now
        )
	));
    }
}