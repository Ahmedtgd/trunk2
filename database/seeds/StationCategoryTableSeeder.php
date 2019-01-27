<?php

use Illuminate\Database\Seeder;

class StationCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('stationcategory')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('stationcategory')->insert(array (
            0 => array(
                'station_id' => 1,
                'category_id' => 5,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            1 => array(
                'station_id' => 2,
                'category_id' => 5,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            2 => array(
                'station_id' => 3,
                'category_id' => 5,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            3 => array(
                'station_id' => 4,
                'category_id' => 5,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            4 => array(
                'station_id' => 5,
                'category_id' => 5,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            5 => array(
                'station_id' => 6,
                'category_id' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            6 => array(
                'station_id' => 7,
                'category_id' => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            7 => array(
                'station_id' => 8,
                'category_id' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            8 => array(
                'station_id' => 9,
                'category_id' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            9 => array(
                'station_id' => 10,
                'category_id' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            10 => array(
                'station_id' => 11,
                'category_id' => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            11 => array(
                'station_id' => 12,
                'category_id' => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            12 => array(
                'station_id' => 13,
                'category_id' => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            13 => array(
                'station_id' => 14,
                'category_id' => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            14 => array(
                'station_id' => 15,
                'category_id' => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            15 => array(
                'station_id' => 16,
                'category_id' => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            16 => array(
                'station_id' => 17,
                'category_id' => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            17 => array(
                'station_id' => 18,
                'category_id' => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            18 => array(
                'station_id' => 19,
                'category_id' => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            19 => array(
                'station_id' => 20,
                'category_id' => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            20 => array(
                'station_id' => 21,
                'category_id' => 4,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            21 => array(
                'station_id' => 22,
                'category_id' => 4,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            22 => array(
                'station_id' => 23,
                'category_id' => 4,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            23 => array(
                'station_id' => 24,
                'category_id' => 4,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            24 => array(
                'station_id' => 25,
                'category_id' => 4,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            25 => array(
                'station_id' => 26,
                'category_id' => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            26 => array(
                'station_id' => 27,
                'category_id' => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            27 => array(
                'station_id' => 28,
                'category_id' => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            28 => array(
                'station_id' => 29,
                'category_id' => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            29 => array(
                'station_id' => 30,
                'category_id' => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            30 => array(
                'station_id' => 31,
                'category_id' => 7,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            31 => array(
                'station_id' => 32,
                'category_id' => 7,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            32 => array(
                'station_id' => 33,
                'category_id' => 7,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            33 => array(
                'station_id' => 34,
                'category_id' => 7,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            34 => array(
                'station_id' => 35,
                'category_id' => 7,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            35 => array(
                'station_id' => 36,
                'category_id' => 8,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            36 => array(
                'station_id' => 37,
                'category_id' => 8,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            37 => array(
                'station_id' => 38,
                'category_id' => 8,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            38 => array(
                'station_id' => 39,
                'category_id' => 8,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            39 => array(
                'station_id' => 40,
                'category_id' => 8,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            40 => array(
                'station_id' => 41,
                'category_id' => 9,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            41 => array(
                'station_id' => 42,
                'category_id' => 9,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            42 => array(
                'station_id' => 43,
                'category_id' => 9,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            43 => array(
                'station_id' => 44,
                'category_id' => 9,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            44 => array(
                'station_id' => 45,
                'category_id' => 9,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            45 => array(
                'station_id' => 46,
                'category_id' => 10,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            46 => array(
                'station_id' => 47,
                'category_id' => 10,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            47 => array(
                'station_id' => 48,
                'category_id' => 10,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            48 => array(
                'station_id' => 49,
                'category_id' => 10,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            49 => array(
                'station_id' => 50,
                'category_id' => 10,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
             50 => array(
                'station_id' => 51,
                'category_id' => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
             51 => array(
                'station_id' => 52,
                'category_id' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            )
        ));
    }
}
