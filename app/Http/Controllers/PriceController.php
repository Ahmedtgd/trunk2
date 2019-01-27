<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Globals;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Http\Controllers\UtilityController;


class PriceController extends Controller
{
   /*
    This controller only outputs the price for a product
    Every calculation in cents
    float is the defacto rule here.
   */
    public $globals;
    public $product;
    public $delivery_type;
    public $delivery_charge;
    public $gst;
    public $del_array=array(); //KeyValue | key is product_id
    public function __construct() {
        # code...
    }
   
    public function init($product_id,$mode="total",$delivery_type="first") {
        $this->product= Product::find($product_id);
        $this->globals= Globals::first();
        $this->delivery_type=$delivery_type;
        try {
            $this->delivery_charge=$this->getDelivery();
        } catch (\Exception $e) {
            $this->delivery_charge=0;
        }
        
        $this->gst= $this->getGST();
        $ret=0;
        switch ($mode) {
            case 'total':
                $ret=$this->totalPrice();
                break;
            case 'gst':
                # code...
                $ret=$this->gst;
                break;
            case 'raw':
                # code..
                $ret= $this->rawPrice();
                break;
            case 'price':
                # code..
                $ret= $this->getPrice();            
                break;
            case 'delivery':
                # code...
                $ret=$this->delivery_charge;
                break;
            case 'gstExists':
                $ret= $this->gstExists();
                break;
            default:
                # code...
                break;
        }
        return $ret;
    }

    public function getPrice() {
		$ret = 0;
        $p = $this->product;
		if ($p->discounted_price != 0 and
			$p->discounted_price <  $p->retail_price) {

            $ret =  $p->discounted_price;

		} else {
			$ret = $p->retail_price;
		}

        return $ret;
    }

    public function gstExists()
    {
        $ret=0;
        try {
            // $merchant_id= MerchantProduct::where(
            //     'product_id',$this->product->id
            //     )
            //     ->first()->merchant_id;
            $merchant_id=UtilityController::productMerchantId($this->product->id);
            $mer=Merchant::find($merchant_id);
            if (!is_null($mer->gst)) {
                $ret=1;
            }
        } catch (\Exception $e) {
            
        }
        
        
        return $ret;
    }

    public function getGST() {
		$ret = 0.0;

        /* grossTotal is price+delivery*/
        $grossTotal= $this->delivery_charge; 
        $globals=$this->globals;
		$gstExists=$this->gstExists();
        if ($gstExists==1) {
            $ret = floatval($globals->gst_rate*$grossTotal)/100;
        } 

		return $ret;
    }

    public function getDelivery() {
        $globals= $this->globals;
        $logistic_comm_rate= $globals->logistic_commission;
        $delivery=0.0;
        // Filter
        if (in_array($this->product->id,$this->del_array)) {
            $delivery=0.0;
           
        }
        else{
            if($this->product->free_delivery == 1){
                    $delivery = 0.0;
            } else{
                if($this->product->del_option == "own"){
                    switch ($this->delivery_type) {
                        case 'first':
                            $delivery=$this->product->del_west_malaysia;
                            break;
                        case 'second':
                            # code...
                            $delivery=$this->product->del_sabah_labuan;
                            break;
                        case 'third':
                            # code...
                            $delivery=$this->product->del_sarawak;
                            break;
                        case 'last':
                            $delivery=$this->product->del_worldwide;
                            break;
                        default:
                            # code...
                            break;
                    }
        //         $delivery = $this->product->del_west_malaysia ?
    				// $this->product->del_west_malaysia : "0.0";

                } else {
    				$delivery = (
    					$this->product->del_width *
    					$this->product->del_lenght *
    					$this->product->del_height *
    					$globals->cms_pricing
    				) + (
    					$this->product->del_weight *
    					$globals->grs_pricing
    				);
    			}       
    		}
           array_push($this->del_array,$this->product->id);
        }

        
        $logistic_commission= $logistic_comm_rate * $delivery/100;
        

        return $delivery+ $logistic_commission;
    }

    public function rawPrice() {
        // Returns Price without GST
       
        return $this->getPrice() + $this->delivery_charge;

    }

    public function totalPrice() {
        try {
            return  $this->rawPrice() +$this->gst; 
        } catch (\Exception $e) {
            return 9999999999;
        }
       
    }

    /*  Functions , To Get Something*/ 

    public  function trueDelivery($delivery_charge)
    {
        // $this->product= Product::find($product_id);
        $delivery_charge=$delivery_charge*100;
        $globals= Globals::first();
        $logistic_comm_rate= $globals->logistic_commission;
        $logistic_commission= $logistic_comm_rate * $delivery_charge/100;
        
        $dt= $delivery_charge+$logistic_commission;
        $gst= ($globals->gst_rate*$dt)/100;
        return ($dt+$gst)/100;
    }

    public $order;
    public $payment;
    public function old()
    {
        # code...
    }
    public static function oldGST()
    {
        # code...
    }
}
