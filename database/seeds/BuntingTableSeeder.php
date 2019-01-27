<?php

use Illuminate\Database\Seeder;

class BuntingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bunting')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();

        \DB::table('bunting')->insert(array (
            0 => array(
                'album_id' => '1',
                'image' => 'bunting.jpg',
                'created_at' => $now,
                'updated_at' => $now
            ),
            1 => array(
                'album_id' => '2',
                'image' => 'bunting1.jpg',
                'created_at' => $now,
                'updated_at' => $now
            ),
        ));
    }
}
