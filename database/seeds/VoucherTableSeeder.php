<?php

use Illuminate\Database\Seeder;

class VoucherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = App\Models\Product::take(15)->get();
        foreach ($products as $product) {
            $product->type = "voucher";
            $product->save();
            $this->createVoucher($product);
        }


    }


    /**
     * @param $product
     */
    private function createVoucher($product)
    {
        $voucher = factory(App\Models\Voucher::class)->make();
        $product->voucher()->save($voucher);
    }
}
