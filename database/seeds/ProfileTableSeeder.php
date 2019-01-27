<?php

use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('profile')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('profile')->insert(array (
            0 => array(
                'album_id' => 1,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            1 => array(
                'album_id' => 2,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            2 => array(
                'album_id' => 3,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            3 => array(
                'album_id' => 4,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            4 => array(
                'album_id' => 5,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            5 => array(
                'album_id' => 6,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            6 => array(
                'album_id' => 7,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            7 => array(
                'album_id' => 8,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            8 => array(
                'album_id' => 9,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            9 => array(
                'album_id' => 10,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            10 => array(
                'album_id' => 11,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            11 => array(
                'album_id' => 12,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            12 => array(
                'album_id' => 13,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            13 => array(
                'album_id' => 14,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            14 => array(
                'album_id' => 15,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            15 => array(
                'album_id' => 16,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            16 => array(
                'album_id' => 17,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            17 => array(
                'album_id' => 18,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            18 => array(
                'album_id' => 19,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            19 => array(
                'album_id' => 20,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            20 => array(
                'album_id' => 21,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            21 => array(
                'album_id' => 22,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            22 => array(
                'album_id' => 23,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            23 => array(
                'album_id' => 24,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            24 => array(
                'album_id' => 25,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            25 => array(
                'album_id' => 26,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            26 => array(
                'album_id' => 27,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            27 => array(
                'album_id' => 28,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            28 => array(
                'album_id' => 29,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            29 => array(
                'album_id' => 30,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            30 => array(
                'album_id' => 31,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            31 => array(
                'album_id' => 32,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            32 => array(
                'album_id' => 33,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            33 => array(
                'album_id' => 34,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            34 => array(
                'album_id' => 35,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            35 => array(
                'album_id' => 36,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            36 => array(
                'album_id' => 37,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            37 => array(
                'album_id' => 38,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            38 => array(
                'album_id' => 39,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            39 => array(
                'album_id' => 40,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            40 => array(
                'album_id' => 41,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            41 => array(
                'album_id' => 42,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            42 => array(
                'album_id' => 43,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            43 => array(
                'album_id' => 44,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            44 => array(
                'album_id' => 45,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            45 => array(
                'album_id' => 46,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            46 => array(
                'album_id' => 47,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            47 => array(
                'album_id' => 48,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            48 => array(
                'album_id' => 49,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            49 => array(
                'album_id' => 50,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            50 => array(
                'album_id' => 51,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
            51 => array(
                'album_id' => 52,
                'signboard_id' => 11,
                'bunting_id' => 1,
                'vbanner_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ),
        ) );
    }
}
