<?php

use Illuminate\Database\Seeder;

class DescimageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('descimage')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('descimage')->insert(array (
            0 => array(
                'merchant_id' => 1,
                'descphoto'   => '01.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            1 => array(
                'merchant_id' => 1,
                'descphoto'   => '03.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            2 => array(
                'merchant_id' => 1,
                'descphoto'   => '03.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            3 => array(
                'merchant_id' => 1,
                'descphoto'   => '04.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            4 => array(
                'merchant_id' => 1,
                'descphoto'   => '05.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            5 => array(
                'merchant_id' => 1,
                'descphoto'   => '06.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            6 => array(
                'merchant_id' => 1,
                'descphoto'   => '07.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
            7 => array(
                'merchant_id' => 1,
                'descphoto'   => '08.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            )
        ));
    }
}
