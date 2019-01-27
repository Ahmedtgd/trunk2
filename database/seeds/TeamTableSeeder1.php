<?php

use Illuminate\Database\Seeder;

class TeamTableSeeder1 extends Seeder
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
                'merchant_id' => 26,
                'full_name'   => 'Lee Teck Meng',
                'post'        => 'Managing Director',
                'description' => 'We manufacture home care products under the brand Kleenso with vision of provide extreme care towards skin protection, environmental friendliness and specialised cleaning solution.',
                'photo'       => 'wilkeshr.jpg',
                'deleted_at'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now
            )
        ));
    }
}
