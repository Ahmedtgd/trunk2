<?php

use Illuminate\Database\Seeder;

class TeamTableSeeder23 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('team')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('team')->insert(array (
            0 => array(
                'merchant_id' => 1,
                'full_name'   => 'Mr Lee Teck Meng',
                'post'        => 'Director',
                'description' => 'Quality is our commitment, every production batch must go through stability test and quality control test.',
                'photo'       => 'kleenso.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ),
        ));
    }
}
