<?php

use Illuminate\Database\Seeder;

class UserTableSeeder1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //\DB::table('users')->truncate();

        // Generate portable password
        $password = \Illuminate\Support\Facades\Hash::make('12345678');

        // Create an admin
        $admin = factory(App\Models\User::class)
            ->create([
                'email'     => 'admin@admin.com',
                'password'  => $password
            ]);
        //
        \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findRoleBySlug('adm')
            ->users()
            ->attach($admin);


        // Create 5 Buyers
        //$addresses = App\Models\Address::orderBy('id','desc')->take(5)->get();
        factory(App\Models\User::class, 20)
            ->create(['password'  => $password])
            ->each(function($u) {
                $role = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findRoleBySlug('byr');

                $role->users()
                    ->attach($u);
            });

        // Create 5 Merchants
        factory(App\Models\User::class, 5)
            ->create(['password'  => $password])
            ->each(function($u) {
                \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findRoleBySlug('mer')
                    ->users()
                    ->attach($u);
            });

        // Create 5 Dealers
        factory(App\Models\User::class, 5)
            ->create(['password'  => $password])
            ->each(function($u) {
                \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findRoleBySlug('dlr')
                    ->users()
                    ->attach($u);
            });

        //Create 5 Social Media Marketer
        factory(App\Models\User::class, 5)
            ->create(['password'  => $password])
            ->each(function($u) {
                \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findRoleBySlug('smm')
                    ->users()
                    ->attach($u);
            });

    }
}
