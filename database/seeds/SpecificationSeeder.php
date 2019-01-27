<?php

use Illuminate\Database\Seeder;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Models\Product::all();

        foreach ($products as $product) {
            $spec = factory(\App\Models\Specification::class)->make();
            $spec->save();

            $product->specification()->attach($spec->id);
        }
    }
}
