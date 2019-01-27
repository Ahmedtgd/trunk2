<?php

use Illuminate\Database\Seeder;

class WholesaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       \DB::table('wholesale')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        $count = 1;
        for($i = 0 ; $i < 50; $i++){
            if($count == 6) {
                $count = 1;
            }
            \DB::table('wholesale')->insert(array (
                $count => array (
                    'product_id'   => $i + 1,
                    'autolink_id'   => $i + 1,
                    'funit'        => 1,
                    'unit'         => 19,
                    'price'        => 5000,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ),
                $count+1 => array (
                    'product_id'   => $i + 1,
                    'autolink_id'   => $i + 1,
                    'funit'        => 20,
                    'unit'         => 79,
                    'price'        => 4500,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ),
                $count+2 => array (
                    'product_id'   => $i + 1,
                    'autolink_id'   => $i + 1,
                    'funit'        => 80,
                    'unit'         => 199,
                    'price'        => 4000,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ),
                $count+3 => array (
                    'product_id'   => $i + 1,
                    'autolink_id'   => $i + 1,
                    'funit'        => 200,
                    'unit'         => 499,
                    'price'        => 3500,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ),
                $count+4 => array (
                    'product_id'   => $i + 1,
                    'autolink_id'   => $i + 1,
                    'funit'        => 500,
                    'unit'         => 799,
                    'price'        => 3000,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ),
                $count+5 => array (
                    'product_id'   => $i + 1,
                    'autolink_id'   => $i + 1,
                    'funit'        => 800,
                    'unit'         => 1000,
                    'price'        => 2000,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ),
            ));
            $count++;
        }
    }
}
