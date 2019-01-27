<?php

use Illuminate\Database\Seeder;

class AlbumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('album')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();

        \DB::table('album')->insert(array (
            0 => array(
                'merchant_id' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array(
                'merchant_id' => '2',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array(
                'merchant_id' => '3',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array(
                'merchant_id' => '4',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array(
                'merchant_id' => '5',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array(
                'merchant_id' => '6',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            6 => array(
                'merchant_id' => '7',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            7 => array(
                'merchant_id' => '8',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            8 => array(
                'merchant_id' => '9',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            9 => array(
                'merchant_id' => '10',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            10 => array(
                'merchant_id' => '11',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            11 => array(
                'merchant_id' => '12',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            12 => array(
                'merchant_id' => '13',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            13 => array(
                'merchant_id' => '14',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            14 => array(
                'merchant_id' => '15',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            15 => array(
                'merchant_id' => '16',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            16 => array(
                'merchant_id' => '17',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            17 => array(
                'merchant_id' => '18',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            18 => array(
                'merchant_id' => '19',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            19 => array(
                'merchant_id' => '20',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            20 => array(
                'merchant_id' => '21',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            21 => array(
                'merchant_id' => '22',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            22 => array(
                'merchant_id' => '23',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            23 => array(
                'merchant_id' => '24',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            24 => array(
                'merchant_id' => '25',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            25 => array(
                'merchant_id' => '26',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            26 => array(
                'merchant_id' => '27',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            27 => array(
                'merchant_id' => '28',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            28 => array(
                'merchant_id' => '29',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            29 => array(
                'merchant_id' => '30',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            30 => array(
                'merchant_id' => '31',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            31 => array(
                'merchant_id' => '32',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            32 => array(
                'merchant_id' => '33',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            33 => array(
                'merchant_id' => '34',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            34 => array(
                'merchant_id' => '35',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            35 => array(
                'merchant_id' => '36',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            36 => array(
                'merchant_id' => '37',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            37 => array(
                'merchant_id' => '38',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            38 => array(
                'merchant_id' => '39',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            39 => array(
                'merchant_id' => '40',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            40 => array(
                'merchant_id' => '41',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            41 => array(
                'merchant_id' => '42',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            42 => array(
                'merchant_id' => '43',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            43 => array(
                'merchant_id' => '44',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            44 => array(
                'merchant_id' => '45',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            45 => array(
                'merchant_id' => '46',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            46 => array(
                'merchant_id' => '47',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            47 => array(
                'merchant_id' => '48',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            48 => array(
                'merchant_id' => '49',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            49 => array(
                'merchant_id' => '50',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            50 => array(
                'merchant_id' => '51',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            51  => array(
                'merchant_id' => '52',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}
