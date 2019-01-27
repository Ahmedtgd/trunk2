<?php

use Illuminate\Database\Seeder;

class VBannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vbanner')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();

        \DB::table('vbanner')->insert(array (
            0 => array(
                'album_id' => '1',
                'image' => 'vbanner.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array(
                'album_id' => '2',
                'image' => 'vbanner1.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}
