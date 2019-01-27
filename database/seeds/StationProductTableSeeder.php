<?php

use Illuminate\Database\Seeder;

class StationProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \DB::table('stationsproduct')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('stationsproduct')->insert(array (
            0 => array (
                'station_id' => 6,
                'sproduct_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'station_id' => 6,
                'sproduct_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'station_id' => 6,
                'sproduct_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array (
                'station_id' => 6,
                'sproduct_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array (
                'station_id' => 6,
                'sproduct_id' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array (
                'station_id' => 6,
                'sproduct_id' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            6 => array (
                'station_id' => 6,
                'sproduct_id' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            7 => array (
                'station_id' => 6,
                'sproduct_id' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            8 => array (
                'station_id' => 9,
                'sproduct_id' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            9 => array (
                'station_id' => 3,
                'sproduct_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            )
        ));
    }
}
