<?php

use Illuminate\Database\Seeder;

class SpecialPorderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('merchantproduct')->where('product_id', '=', 18)->update(['merchant_id'=>9]);
		\DB::table('merchantproduct')->where('product_id', '=', 19)->update(['merchant_id'=>9]);
		\DB::table('merchantproduct')->where('product_id', '=', 20)->update(['merchant_id'=>9]);

		$payment_id = \DB::table('payment')->insertGetId(array (
				'receivable' => 10000,
				'osmall_commission' => 8,
				'status' => 'pending',
				'note' => 'This is a test of Note',
				'consignment' =>  null,
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
		));		

		$porder_id = \DB::table('porder')->insertGetId(array (
				'user_id' => 196,
				'courier_id' => 0,
				'address_id' => 1,
				'status' => 'pending',
				'payment_id' => $payment_id,
				'station_id' => 0,
				'description' => 'This is a test of description',
				'source' => 'b2c',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
		));	
		
		\DB::table('orderproduct')->insert(array (
			0 => array (
				'porder_id' => $porder_id,
				'product_id' => 18,
				'order_price' => 4000,
				'quantity' => 2,
				'shipping_cost' => null,
				'status' => 'pending',
				'commission_paid' => 0,
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'porder_id' => $porder_id,
				'product_id' => 19,
				'order_price' => 2000,
				'quantity' => 1,
				'shipping_cost' => null,
				'status' => 'pending',
				'commission_paid' => 0,
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			2 => array (
				'porder_id' => $porder_id,
				'product_id' => 20,
				'order_price' => 4000,
				'quantity' => 2,
				'shipping_cost' => null,
				'status' => 'pending',
				'commission_paid' => 0,
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			) 
		));		
		
		$receipt_id = \DB::table('receipt')->insertGetId(array (
				'porder_id' => $porder_id,
				'do_password' => '52398650',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
		));	

		$do_id = \DB::table('deliveryorder')->insertGetId(array (
				'receipt_id' => $receipt_id,
				'employee_id' => 1,
				'status' => 'pending',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
		));			

		\DB::table('deliveryordersproduct')->insert(array (
			0 => array (
				'do_id' => $do_id,
				'product_id' => 18,
				'quantity' => 2,
				'status' => 'pending',
				'remark' => 'test',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'do_id' => $do_id,
				'product_id' => 19,
				'quantity' => 1,
				'status' => 'pending',
				'remark' => 'test',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			2 => array (
				'do_id' => $do_id,
				'product_id' => 20,
				'quantity' => 2,
				'status' => 'pending',
				'remark' => 'test',
				'deleted_at' =>  null,
				'created_at' => $now,
				'updated_at' => $now,
			) 
		));		
    }
}
