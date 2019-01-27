<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cart;
class CartHelperController extends Controller
{
    /*
        Updates Cart!

    */ 
    public function cartStatusUpdate($cartId,$newQuantity)
    {
        
    }
    /*

        Returns the state of the cart!
    */ 
    public function cartStatus ()
    {
        $ret=["status"=>"failure"];
        $totalPrice=0;
        $products=array();
        $merchant=array();
        try {
            foreach (Cart::contents() as $item) {
                $merchantId=UtilityController::productMerchantId($item->id);
                if (!array_key_exists($merchantId,$merchant)) {
                    $merchant[$merchantId]["priceWithoutDelivery"]=($item->price*$item->quantity);
                    $merchant[$merchantId]["delivery"]=($item->delivery_price*100);
                }else{
                    $merchant[$merchantId]["priceWithoutDelivery"]+=($item->price*$item->quantity);
                    $merchant[$merchantId]["delivery"]+=($item->delivery_price*100);
                }
                $totalPrice+=($item->price*$item->quantity)+($item->delivery_price*100);
                $products["formatted_id"]=IdController::nP($item->id);
                $products["subTotal"]=($item->price*$item->quantity)+($item->delivery_price*100);

            }
            $ret["totalItems"]=Cart::totalItems();
            $ret["totalPrice"]=$totalPrice;
        } catch (\Exception $e){
            
        }
        $ret["status"]="success";
        $ret["merchantCalc"]=$merchant;
        $ret["productCalc"]=$products;
        return response()->json($ret);
    }
}
