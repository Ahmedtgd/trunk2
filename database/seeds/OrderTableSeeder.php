<?php

use App\Models\OrderProduct;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Address::class, 'shipping')->create();

        factory(App\Models\Courier::class)->create();


        $v_pro = \App\Models\Product::orderBy('id', 'desc')->take(3)->get();
        if (sizeof($v_pro) == 0) return "false";

        $p1 = $v_pro[0];
        $p1->type = 'voucher';
        $p1->save();

        $p2 = $v_pro[1];
        $p2->type = 'voucher';
        $p2->save();

        $p3 = $v_pro[2];
        $p3->type = 'voucher';
        $p3->save();

//        $p1->merchant()->attach([1]);
//        $p2->merchant()->attach([1]);
//        $p3->merchant()->attach([1]);

        factory(\App\Models\POrder::class, 10)->create()->each(function($o) use($p1,$p2,$p3) {
            $o->products()->attach([1=>[
                'quantity' => rand(1, 10)
            ]]);
            $o->products()->attach([2=>[
                'quantity' => rand(1, 10)
            ]]);
            $o->products()->attach([3=>[
                'quantity' => rand(1, 10)
            ]]);
            $o->products()->attach([4=>[
                'quantity' => rand(1, 10)
            ]]);

        });

        factory(\App\Models\POrder::class, 10)->create()->each(function($o) use($p1,$p2,$p3) {
            $op = new OrderProduct();
            $op->product_id = $p1->id;
            $op->porder_id = $o->id;
            $op->quantity = rand(1, 10);
            $op->save();


            $op = new OrderProduct();
            $op->product_id = $p2->id;
            $op->porder_id = $o->id;
            $op->quantity = rand(1, 10);
            $op->save();


            $op = new OrderProduct();
            $op->product_id = $p3->id;
            $op->porder_id = $o->id;
            $op->quantity = rand(1, 10);
            $op->save();

        });

    }
}
