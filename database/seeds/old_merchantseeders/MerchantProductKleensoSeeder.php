<?php

use Illuminate\Database\Seeder;

class MerchantProductKleensoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('merchantproduct')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('merchantproduct')->insert(array (
            0 => array(
                'merchant_id' => 26,
                'product_id' => 1,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            1 => array(
                'merchant_id' => 26,
                'product_id' => 2,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            2 => array(
                'merchant_id' => 26,
                'product_id' => 3,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            3 => array(
                'merchant_id' => 26,
                'product_id' => 4,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            4 => array(
                'merchant_id' => 26,
                'product_id' => 5,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            5 => array(
                'merchant_id' => 26,
                'product_id' => 6,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            6 => array(
                'merchant_id' => 26,
                'product_id' => 7,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            7 => array(
                'merchant_id' => 26,
                'product_id' => 8,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            8 => array(
                'merchant_id' => 26,
                'product_id' => 9,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            9 => array(
                'merchant_id' => 26,
                'product_id' => 10,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            10 => array(
                'merchant_id' => 26,
                'product_id' => 11,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            11 => array(
                'merchant_id' => 26,
                'product_id' => 12,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            12 => array(
                'merchant_id' => 26,
                'product_id' => 13,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            13 => array(
                'merchant_id' => 26,
                'product_id' => 14,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            14 => array(
                'merchant_id' => 26,
                'product_id' => 15,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            15 => array(
                'merchant_id' => 26,
                'product_id' => 16,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            16 => array(
                'merchant_id' => 26,
                'product_id' => 17,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            17 => array(
                'merchant_id' => 26,
                'product_id' => 18,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            18 => array(
                'merchant_id' => 26,
                'product_id' => 19,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            19 => array(
                'merchant_id' => 26,
                'product_id' => 20,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            20 => array(
                'merchant_id' => 26,
                'product_id' => 21,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            21 => array(
                'merchant_id' => 26,
                'product_id' => 22,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            22 => array(
                'merchant_id' => 26,
                'product_id' => 23,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            23 => array(
                'merchant_id' => 26,
                'product_id' => 24,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            24 => array(
                'merchant_id' => 26,
                'product_id' => 25,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            25 => array(
                'merchant_id' => 26,
                'product_id' => 26,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
        ));
    }
}
