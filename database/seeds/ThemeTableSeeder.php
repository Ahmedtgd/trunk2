<?php

use Illuminate\Database\Seeder;

class ThemeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('theme')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();

        \DB::table('theme')->insert(array (
            0 => array(
                'profile_id' => '1',
                'image' => 'theme.jpg',
                'bg_color' => '#ffffff',
                'font_family' => 'sans-serif, arial',
                'font_color' => '#000000',
                'font_style' => 'normal',
                'font_size' => '12',
                'created_at' => $now,
                'updated_at' => $now
            )
        ));
    }
}
