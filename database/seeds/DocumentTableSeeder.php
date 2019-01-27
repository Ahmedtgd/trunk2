<?php

use Illuminate\Database\Seeder;

class DocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \DB::table('document')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('document')->insert(array (
            0 => array (
                'name' => 'director',
                'description' => '',
                'path' => 'kleensodirector.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ),
       ));
    }
}