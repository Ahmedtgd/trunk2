<?php

use Illuminate\Database\Seeder;

class OcbcTrailerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ocbc_trailer')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('ocbc_trailer')->insert(array (
            0 => array(
                'id' => 1,
                'record_type' => '01',
                'total_count' => '000004',
                'total_amount' => '0000000000001562220',
                
                'created_at' => $now,
                'updated_at' => $now
            )
        ) );
    }
}
