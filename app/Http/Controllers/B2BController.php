<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Wholesale;
use App\Models\ProductDealer;
use App\Models\User;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Autolink;
use DB;
use App\Exceptions\CustomException;
use Exception;
use \Illuminate\Database\QueryException;
use Auth;

class B2BController extends Controller
{
    public function showProduct($id)
    {   
        //Lazy loading
        $merchant = Merchant::with('categories')->find($id);
        
        /**
        // Get Album ID 
        try{
            $album    = DB::table('album')->where('merchant_id',$id)->first();
            $album_id = $album->id;
        }catch(\Exception $e){
            $album_id = false;
        }
        //Get Profile ID

        try {
            $profile = DB::table('profile')->where('album_id',$album_id)->first();
            $profile_id=$profile->id;
        } catch (\Exception $e) {
            $profile_id=false;    
        }
        //Get theme 
        if ($profile_id!=false) {
            # code...
               try {
                    $theme= DB::table('theme')->where('profile_id',$profile_id)->firstorFail();
                    } catch (\Exception $e) {
                        $theme= null;
                    }
        }
        if ($album_id!=false) {
            //Signboard
            try {
                $signboard=DB::table('signboard')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $signboard=null;
            }
            //Bunting
            try {
                $bunting= DB::table('bunting')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $bunting=null;
            }
            //Vbanner
            try {
                $vbanner=DB::table('vbanner')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $vbanner=null;
            }
        }

        */

        $enableSpecialAndWholesalePrice = 0;
        $user_id  = Auth::id();
        $showAutolink =  0;

        $getInitiatorOrResponder =  Autolink::where('initiator_uid',
			$user_id)->orWhere('responder_uid', $user_id)->first();

        if(isset($getInitiatorOrResponder)){
            $viewForDealers = 1;
        }else{
            $viewForDealers = 0;
        }
        
        if(Auth::check()){
            if ($viewForDealers){
                $products = $this->getProductsForDealers($id); 
            }else {
                $products = $this->getProductsForRegularUsers($id);
                $showAutolink = 1;
            }
        }else{
            $products = $this->getProductsForAnonymous($id);
        }

        return view('b2b_products')->withProducts($products)
                ->withMerchant($merchant)
                ->with('showAutolink', $showAutolink);
        
        // return view('b2b_products')
        //     ->with('merchant',$merchant)
        //     ->with('theme',$theme)
        //     ->with('bunting',$bunting)
        //     ->with('vbanner',$vbanner)
        //     ->with('signboard',$signboard)
        //     ->with('products',$products)
        //     ->with('type','oshop');
    }

    private function getProductsForDealers($id){
        try {
            $products = DB::select(DB::raw("
			SELECT p.* FROM product p, merchantproduct op, wholesale w,
				productdealer pd
			WHERE op.merchant_id = $id AND
				((p.id = w.product_id and price > 0) OR
				(p.id = pd.product_id and special_price > 0))
			GROUP BY p.id"));

            foreach ($products as $product) {
                $special_price = ProductDealer::where('product_id', $product->id)->first(['special_funit', 'special_unit', 'special_price']);
                if($special_price){
                    $product->special_funit = $special_price->special_funit;
                    $product->special_unit = $special_price->special_unit;
                    $product->special_price = $special_price->special_price;
                }
            }
        } catch(Exception $e){
            throw new CustomException($e);
        }

        return $products;
    }

    private function getProductsForRegularUsers($id){
        try {
            $products = DB::select(DB::raw("
			SELECT p.* FROM product p, merchantproduct op
			WHERE op.merchant_id = $id AND
			p.display_non_autolink = true GROUP BY p.id"));

        } catch(Exception $e){
            throw new CustomException($e);
        }

        return $products;
    }

    private function getProductsForAnonymous($id){
        try {
            $products = DB::select(DB::raw("
			SELECT p.* FROM product p, merchantproduct op
			WHERE op.merchant_id = $id GROUP BY p.id"));

        } catch(Exception $e){
            throw new CustomException($e);
        }

        return $products;
    }
}
