<?php

use Illuminate\Database\Seeder;

class SmmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $now = \Carbon\Carbon::now()->toDateTimeString();

        \DB::table('smmout')->truncate();
        \DB::table('smmout')->insert(array(
            0 => array(
                'user_id' => 1,
                'product_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array(
                'user_id' => 2,
                'product_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array(
                'user_id' => 3,
                'product_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array(
                'user_id' => 2,
                'product_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array(
                'user_id' => 1,
                'product_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array(
                'user_id' => 3,
                'product_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            6 => array(
                'user_id' => 1,
                'product_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));

        \DB::table('smmin')->truncate();
        \DB::table('smmin')->insert(array(
            0 => array(
                'smmout_id' => 1,
                'smedia_id' => 1,
                'source_ip' => 1,
                'response' => 'buy',
                'porder_id' => 1,
                'quantity' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array(
                'smmout_id' => 1,
                'smedia_id' => 1,
                'source_ip' => 1,
                'response' => 'buy',
                'porder_id' => 1,
                'quantity' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array(
                'smmout_id' => 2,
                'smedia_id' => 1,
                'source_ip' => 1,
                'response' => 'buy',
                'porder_id' => 2,
                'quantity' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array(
                'smmout_id' => 2,
                'smedia_id' => 1,
                'source_ip' => 1,
                'response' => 'buy',
                'porder_id' => 2,
                'quantity' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array(
                'smmout_id' => 2,
                'smedia_id' => 1,
                'source_ip' => 1,
                'response' => 'buy',
                'porder_id' => 2,
                'quantity' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array(
                'smmout_id' => 3,
                'smedia_id' => 1,
                'source_ip' => 1,
                'response' => 'view',
                'porder_id' => 3,
                'quantity' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            6 => array(
                'smmout_id' => 3,
                'smedia_id' => 1,
                'source_ip' => 1,
                'response' => 'view',
                'porder_id' => 3,
                'quantity' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}