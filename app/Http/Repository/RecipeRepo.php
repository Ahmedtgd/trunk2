<?php

namespace App\Http\Repository;

use App\Models\Merchant as Merchant;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;

class RecipeRepo {

	public function getRawMaterial()
    {
        $user_id = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        if(count($merchant) == 0){
            return $products = array();
        }
        else{
            return   $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
            ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->leftjoin('q1def','q1def.product_id','=','product.id')
            ->leftjoin('uom','q1def.uom_id','=','uom.id')
            ->whereNull('mp.deleted_at')
            ->where('product.status','!=','transferred')
            ->whereNull('product.deleted_at')
            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
                'q1def.measurement','q1def.unit','uom.symbol',
            ]);
        }
    }
}