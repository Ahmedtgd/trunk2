<?php

use Illuminate\Database\Seeder;

class ProductSpecTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       \DB::table('productspec')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('productspec')->insert(array (
            0 => array (
                'product_id' => '1',
				'spec_id'=>'1',
                'value' => 'asdf asdf sadf sdaf sdaf',
                'deleted_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
				'product_id' => '1',
				'spec_id'=>'2',
                'value' => 'asdf asdf sadf sdaf sdaf',
                'deleted_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'product_id' => '1',
				'spec_id'=>'3',
                'value' => 'asdf asdf sadf sdaf sdaf',
                'deleted_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array (
                 'product_id' => '2',
				'spec_id'=>'1',
                'value' => 'asdf asdf sadf sdaf sdaf',
                'deleted_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array (
                  'product_id' => '2',
				'spec_id'=>'2',
                'value' => 'asdf asdf sadf sdaf sdaf',
                'deleted_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array (
                'product_id' => '2',
				'spec_id'=>'3',
                'value' => 'asdf asdf sadf sdaf sdaf',
                'deleted_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            )
        ));
    }
}
