<?php

use Illuminate\Database\Seeder;

class AdslotproductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \DB::table('adslotproduct')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('adslotproduct')->insert(array (
            0 => array (
                'adslot_id' => '1',
                'product_id' => '101',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'adslot_id' => '2',
                'product_id' => '102',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'adslot_id' => '3',
                'product_id' => '103',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array (
                'adslot_id' => '3',
                'product_id' => '104',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array (
                'adslot_id' => '3',
                'product_id' => '105',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array (
                'adslot_id' => '3',
                'product_id' => '106',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            6 => array (
                'adslot_id' => '4',
                'product_id' => '107',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            7 => array (
                'adslot_id' => '4',
                'product_id' => '108',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            8 => array (
                'adslot_id' => '4',
                'product_id' => '109',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            9 => array (
                'adslot_id' => '4',
                'product_id' => '110',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            10 => array (
                'adslot_id' => '4',
                'product_id' => '111',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            11 => array (
                'adslot_id' => '4',
                'product_id' => '112',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            12 => array (
                'adslot_id' => '4',
                'product_id' => '113',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            13 => array (
                'adslot_id' => '4',
                'product_id' => '114',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            14 => array (
                'adslot_id' => '4',
                'product_id' => '115',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            15 => array (
                'adslot_id' => '4',
                'product_id' => '116',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            16 => array (
                'adslot_id' => '4',
                'product_id' => '117',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            17 => array (
                'adslot_id' => '4',
                'product_id' => '118',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            18 => array (
                'adslot_id' => '4',
                'product_id' => '119',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            19 => array (
                'adslot_id' => '4',
                'product_id' => '120',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            20 => array (
                'adslot_id' => '4',
                'product_id' => '121',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            21 => array (
                'adslot_id' => '5',
                'product_id' => '122',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            22 => array (
                'adslot_id' => '6',
                'product_id' => '123',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            23 => array (
                'adslot_id' => '7',
                'product_id' => '124',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}