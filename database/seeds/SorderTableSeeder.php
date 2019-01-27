<?php

use Illuminate\Database\Seeder;
use App\Models\POrder;
class SorderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \DB::table('sorder')->truncate();
        $faker= Faker\Factory::create();
        $porder = POrder::all()->lists('id')->toArray();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        for ($i=0; $i < 498 ; $i++) { 
        \DB::table('sorder')->insert([
				'porder_id'=>$porder[$i],
				'order_qty'=>$faker->numberBetween(1,80),
				'shipping_cost'=>$faker->numberBetween(10,500),
				'deleted_at'=>$faker->dateTime(),
				'created_at'=>$faker->dateTime(),
				'updated_at'=>$faker->dateTime()
				]);
        }
		\DB::table('sorder')->insert([				
				'porder_id'=>88,
				'order_qty'=>2,
				'shipping_cost'=>$faker->numberBetween(10,500),
				'deleted_at'=>$faker->dateTime(),
				'created_at'=>$faker->dateTime(),
				'updated_at'=>$faker->dateTime()
				]);
		\DB::table('sorder')->where('id', '=', 8)->delete();
		\DB::table('sorder')->insert([				
				'id' => 8,
				'porder_id'=>135,
				'order_qty'=>2,
				'shipping_cost'=>$faker->numberBetween(10,500),
				'deleted_at'=>$faker->dateTime(),
				'created_at'=>$faker->dateTime(),
				'updated_at'=>$faker->dateTime()
				]);
    }
}
