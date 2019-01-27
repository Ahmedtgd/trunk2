<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\OrderProduct;
use DB;

class OrderProductServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        OrderProduct::creating(function($op){
            $logistic_commission=DB::table('global')->pluck('logistic_commission');
            $shipping=$op->actual_delivery_price*(1-($logistic_commission/100));
            $op->shipping_cost=round($shipping);
            $op->log_comm_amount=round(($logistic_commission/100)*$op->order_delivery_price);
            
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
