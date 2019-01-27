<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant;
use Illuminate\Support\Facades\DB;

class SProduct extends Model
{
    protected $table = 'sproduct';
    protected  $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public static function get_commission_products(){


        $selluser = \App\Models\User::find(Auth::user()->id);
        $merchant = Merchant::where('user_id','=',Auth::user()->id)->first();
        $merchant_id = $merchant->id;
        $products = DB::select(DB::raw(
            "select p.id,p.name,p.thumb_photo,np.nproduct_id,hp.product_id,hp.commission_amt, COUNT(rw.item_product_id) as rw_count ".
            "from product as p ".
            "join merchantproduct as mp ".
            "on p.id = mp.product_id ".
            "and mp.merchant_id = ".$merchant_id." ".
            "left join hcap_productcomm as hp ".
            "on p.id = hp.product_id ".
            "left join nproductid as np ".
            "on p.id = np.product_id ".
            "left join rawmaterial as rw ".
            "on p.id = rw.item_product_id ".
            "GROUP BY p.id"));
        return $products;
    }
    public static function get_commission_products_id($id){
        // $merchant_id = Auth::user()->id;
        //$selluser = \App\Models\User::find(Auth::user()->id);
        $merchant = Merchant::where('user_id','=',Auth::user()->id)->first();
        $merchant_id = $merchant->id;
        $products = DB::select(DB::raw(
            "select p.id,p.name,p.thumb_photo,np.nproduct_id,hp.product_id,hp.commission_amt, COUNT(rw.item_product_id) as rw_count,p.type ".
            "from product as p ".
            "join merchantproduct as mp ".
            "on p.id = mp.product_id ".
            "and mp.merchant_id = ".$merchant_id." ".
            "left join hcap_productcomm as hp ".
            "on p.id = hp.product_id ".
            "and hp.sales_member_id = ".$id." ".
            "left join nproductid as np ".
            "on p.id = np.product_id ".
            "left join rawmaterial as rw ".
            "on p.id = rw.item_product_id ".
            "GROUP BY p.id"));
       // dd($products);
        return $products;
    }

}
