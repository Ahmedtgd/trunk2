<?php

use Illuminate\Database\Seeder;

class WishListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\OpenWish::class, 10)->create()->each(function($o) {
//            $o->products()->attach([1=>[
//                'quantity' => rand(1, 100)
//            ]]);
        });

        $this->command->info('Wish List Table Seeded.');
    }
}
