<?php

use Illuminate\Database\Seeder;
use App\Models\POrder;
use App\Models\Product;
class OrderproductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orderproduct')->truncate();
        $faker= Faker\Factory::create();
        $porder = POrder::all()->lists('id')->toArray();
        $product = Product::all()->lists('id')->toArray();

        \DB::table('orderproduct')->insert(array(
            0 => array (
                'porder_id'=>1,
                'product_id'=>1,
                'order_price'=>$faker->numberBetween(1000,99999),
                'quantity'=>$faker->numberBetween(1000,9000),
                'shipping_cost'=>$faker->numberBetween(1000,9000),
                'status'=>"paid",
                'deleted_at'=>null,
                'created_at'=>$faker->dateTime(),
                'updated_at'=>$faker->dateTime()
            ),
            1 => array (
                'porder_id'=>1,
                'product_id'=>2,
                'order_price'=>$faker->numberBetween(1000,99999),
                'quantity'=>$faker->numberBetween(1000,9000),
                'shipping_cost'=>$faker->numberBetween(1000,9000),
                'status'=>"paid",
                'deleted_at'=>null,
                'created_at'=>$faker->dateTime(),
                'updated_at'=>$faker->dateTime()
            ),
            2 => array (
                'porder_id'=>1,
                'product_id'=>3,
                'order_price'=>$faker->numberBetween(1000,99999),
                'quantity'=>$faker->numberBetween(1000,9000),
                'shipping_cost'=>$faker->numberBetween(1000,9000),
                'status'=>"paid",
                'deleted_at'=>null,
                'created_at'=>$faker->dateTime(),
                'updated_at'=>$faker->dateTime()
            ),
        ));

        for ($i=0; $i < 498 ; $i++) {
        	DB::table('orderproduct')->insert([
        		'porder_id'=>$porder[$i],
                'product_id'=>$faker->randomElement($product),
        		'order_price'=>$faker->numberBetween(1000,99999),
        		'quantity'=>$faker->numberBetween(1000,9000),
        		'created_at'=>$faker->dateTime(),
        		'updated_at'=>$faker->dateTime()
        		]);
        }
    }
}


