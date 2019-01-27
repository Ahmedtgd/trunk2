<?php

use Illuminate\Database\Seeder;

class DeliveryOrdersProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['Delivered', 'UnDelivered','Partial','Pending'];
        \DB::table('deliveryordersproduct')->insert(array(
            0 => array (
                'do_id'=>1,
                'product_id'=>1,
                'quantity'=>mt_rand(1,9),
                'status'=>'Pending'
            ),
            1 => array (
                'do_id'=>1,
                'product_id'=>2,
                'quantity'=>mt_rand(1,9),
                'status'=>'Pending'
            ),
            2 => array (
                'do_id'=>1,
                'product_id'=>3,
                'quantity'=>mt_rand(1,9),
                'status'=>'Pending'
            ),
        ));

        for($i = 1; $i < 21; $i++){
            $item_index = array_rand($status);
            \App\Models\DeliveryOrderProduct::create([
                'do_id'             =>      $i,
                'product_id'        =>      mt_rand(1,20),
                'quantity'          =>      mt_rand(1,9),
                'status'            =>      $status[$item_index]]);
        }

    }
}
