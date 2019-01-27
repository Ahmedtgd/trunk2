<?php

use Illuminate\Database\Seeder;

class SpecificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       \DB::table('specification')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('specification')->insert(array (
            0 => array (
                'name' => 'color',
                'description' => 'Color of the product',
                'deleted_at' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
				'name' => 'model',
                'description' => 'Model of the product',
                'deleted_at' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                 'name' => 'size',
                'description' => 'Dimensions (L x W x H)',
                'deleted_at' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array (
                'name' => 'weight',
                'description' => 'Kilogram (Kg)',
                'deleted_at' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array (
                'name' => 'warranty',
                'description' => 'Warranty period (months)',
                'deleted_at' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array (
                'name' => 'warranty_type',
                'description' => 'Warranty type',
                'deleted_at' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            )
        ));
    }
}
