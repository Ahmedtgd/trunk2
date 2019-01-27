<?php

use Illuminate\Database\Seeder;

class AdslotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \DB::table('adslot')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('adslot')->insert(array (
            0 => array (
                'placement' => 't1',
                'name' => 'Landing Page Top T1',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'placement' => 't2',
                'name' => 'Landing Page Top T2',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'placement' => 't3',
                'name' => 'Landing Page Top T3',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array (
                'placement' => 't4',
                'name' => 'Landing Page Top T4',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array (
                'placement' => 't5',
                'name' => 'Landing Page Top T5',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array (
                'placement' => 't6',
                'name' => 'Landing Page Top T6',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            6 => array (
                'placement' => 't7',
                'name' => 'Landing Page Top T7',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            7 => array (
                'placement' => 'f1',
                'name' => 'Landing Page Floor F1',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            8 => array (
                'placement' => 'f2',
                'name' => 'Landing Page Floor F2',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            9 => array (
                'placement' => 'f3',
                'name' => 'Landing Page Floor F3',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            10 => array (
                'placement' => 'f4',
                'name' => 'Landing Page Floor F4',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            11 => array (
                'placement' => 'f5',
                'name' => 'Landing Page Floor F5',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            12 => array (
                'placement' => 'f6',
                'name' => 'Landing Page Floor F6',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            13 => array (
                'placement' => 'f7',
                'name' => 'Landing Page Floor F7',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            14 => array (
                'placement' => 'f8',
                'name' => 'Landing Page Floor F8',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            15 => array (
                'placement' => 'f9',
                'name' => 'Landing Page Floor F9',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            16 => array (
                'placement' => 'f10',
                'name' => 'Landing Page Floor F10',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            17 => array (
                'placement' => 'o1',
                'name' => 'O-Shop Top O1',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            18 => array (
                'placement' => 'o2',
                'name' => 'O-Shop Bottom O2',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            19 => array (
                'placement' => 'x1',
                'name' => 'Top x1',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            20 => array (
                'placement' => 'x2',
                'name' => 'Bottom x2',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}
