<?php

/**
 * Created by Rehman Akbar.
 * User: OsmallDB
 * Date: 6/1/2016
 * Time: 11:09 AM
 */
use Illuminate\Database\Seeder;
use App\Models\OpenWish;

class OpenWishPledgeSeeder extends Seeder
{
    public function run(){
        DB::table('openwishpledge')->truncate();
       $faker = Faker\Factory::create();
        $openwish = OpenWish::all()->lists('id')->toArray();
        for ($i=1; $i < 200; $i++) {
            DB::table('openwishpledge')->insert([
                'openwish_id'     => $faker->randomElement($openwish),
                'smedia_id'      =>	$faker->numberBetween(1,80),
                'smedia_account'        => $faker->email(),
                'source_ip'       =>	$faker->ipv4(),
                'pledged_amt'         =>	$faker->numberBetween(1,500),
                'merchant_help'     =>	$faker->numberBetween(1,500),
                'deleted_at'     =>	$faker->dateTime(),
                'created_at'     =>	$faker->dateTime(),
                'updated_at'     =>	$faker->dateTime(),
            ]);
        }
    }
}