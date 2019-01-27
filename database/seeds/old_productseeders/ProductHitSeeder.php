<?php

use Illuminate\Database\Seeder;

class ProductHitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchant = \App\Models\Merchant::find(1);
		if (empty($merchant)) return "false";



        $products = $merchant->first()->products()->with(['wholesale'])->get();

        foreach ($products as $product) {
            $adSlotProduct = $product->adSlotProduct;
            if(is_null($adSlotProduct)){
                $adSlot = new \App\Models\AdslotProduct();
                $adSlot->product_id = $product->id;
                $adSlot->adslot_id = 10;
                $adSlot->save();
                $adSlotProduct = $adSlot;
            }

            $adSlotProduct->hits()->save(factory(App\Models\AdslotProductHit::class)->make());

            $dealer = $product->dealers;
            if(count($dealer) == 0){
                $dlr = factory(App\Models\Dealer::class)->create();
                $product->dealers()->attach($dlr->id);
            }

            $product->subcat_id = rand(1,10);
            $product->save();
        }
    }
}
