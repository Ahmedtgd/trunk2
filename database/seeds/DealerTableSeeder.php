<?php

use Illuminate\Database\Seeder;

class DealerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Models\User::class, 10)->create()->each(function($u) {
            \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findRoleBySlug('dlr')
                ->users()
                ->attach($u);
            
            $dealer = $u->dealers()->save(factory(App\Models\Dealer::class)->make());
            $dealer->productDealers()->save(factory(App\Models\ProductDealer::class)->make());
        });

        $this->command->info('Dealer Table Seeded.');
    }
}
