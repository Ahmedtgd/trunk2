<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\POrder;
use App\Models\Autolink;
use App\Models\User;

class OpenWishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('openwish')->truncate();
        $faker = Faker\Factory::create();
        $product = Product::all()->lists('id')->toArray();
        $porder = Porder::all()->lists('id')->toArray();
        $autolink = Autolink::all()->lists('id')->toArray();
        $users = User::all()->lists('id')->toArray();
        $status = array('active','executed','delivered','expired');
        for ($i=1; $i < 200; $i++) {
            DB::table('openwish')->insert([
                'user_id'        =>	$faker->randomElement($array = $users),
                'product_id'     => $faker->randomElement($array = $product),
                'porder_id'      =>	$faker->randomElement($array = $porder),
//                'link_id'        => $faker->randomElement($array = $autolink),
                'duration'       =>	$faker->numberBetween(1,80),
                'status'         =>	$faker->randomElement($array = $status),
                'deleted_at'     =>	$faker->dateTime(),
                'created_at'     =>	$faker->dateTime(),
                'updated_at'     =>	$faker->dateTime(),
            ]);
        }
        factory(App\Models\OpenWish::class,15)->create()->each(function($o) {
            $o->pledges()->save(factory(App\Models\OpenWishPledge::class)->make());
        });
    }
}
