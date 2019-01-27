<?php

namespace App\Providers;
use App\Models\Merchant;
use Illuminate\Support\ServiceProvider;

class MerchantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Merchant::updating(function($m){

            if ($m->all_own_delivery==True) {
                $m->all_system_delivery=False;
            }else{
                $m->all_system_delivery=True;
            }
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

