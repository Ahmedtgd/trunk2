<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController as UC;
use DB;
class IdController extends Controller
{
    /* all methods are static */


	public static function nTp($tproduct_id)
     {
        $ret="EEEE".$tproduct_id;
         try {
             $ret= DB::table('ntproductid')
         ->where('tproduct_id',$tproduct_id)
         ->first()->ntproduct_id;
         } catch (\Exception $e) {

             $ret= UC::nsid($tproduct_id);
             if ($tproduct_id == "" or is_null($tproduct_id)) {
                 $ret="--";
             }
         }
         return $ret;
     } 
	
    public static function nP($product_id)
     {
        $ret="EEEE".$product_id;
         try {
             $ret= DB::table('nproductid')
			->where('product_id',$product_id)
			->first()->nproduct_id;
         } catch (\Exception $e) {

             $ret= UC::nsid($product_id);
             if ($product_id == "" or is_null($product_id)) {
                 $ret="--";
             }
         }
         return $ret;
     } 

    public static function nO($porder_id)
    {
        # code...
        $ret="EEEE".$porder_id;
        try {
            $ret=DB::table('nporderid')->where('porder_id',$porder_id)->first()->nporder_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($porder_id);

        }
        return $ret;
    }
	
    public static function nSM($salesmemo_id)
    {
        # code...
        $ret="EEEE".$salesmemo_id;
        try {
            $ret=DB::table('nsalesmemoid')->where('salesmemo_id',$salesmemo_id)->first()->nsalesmemo_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($salesmemo_id);

        }
        return $ret;
    }	
	
    public static function nI($invoice_id)
    {
        # code...
        $ret="EEEE".$invoice_id;
        try {
            $ret=DB::table('ninvoiceid')->where('invoice_id',$porder_id)->first()->ninvoice_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($invoice_id);

        }
        return $ret;
    }	

    public static function nA($autolink_id)
    {
        # code...
        $ret="EEEE".$autolink_id;
        try {
            $ret=DB::table('nautolinkid')->where('autolink_id',$autolink_id)->first()->nautolink_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($autolink_id);
        }
        return $ret;
    }

    public static function nOshop($oshop_id)
    {
        # code...
        $ret="EEEE".$oshop_id;
        try {
            $ret=DB::table('nbranchoshopid')->join('nbranchid','nbranchoshopid.nbranchid_id','=','nbranchid.id')->where('nbranchoshopid.oshop_id',$oshop_id)->first()->nbranch_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($oshop_id);
        }
        return $ret;
    }	
	
    public static function nOutlet($outlet_id)
    {
        # code...
        $ret="EEEE".$outlet_id;
        try {
            $ret=DB::table('nbranchoutletid')->join('nbranchid','nbranchoutletid.nbranchid_id','=','nbranchid.id')->where('nbranchoutletid.outlet_id',$outlet_id)->first()->nbranch_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($outlet_id);
        }
        return $ret;
    }	
	
    public static function nH($hyper_id)
    {
        # code...
        $ret="EEEE".$hyper_id;
        try {
            $ret=DB::table('nhyperid')->where('hyper_id',$hyper_id)->first()->nhyper_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($hyper_id);
        }
        return $ret;
    }	
	
    public static function nDel($delivery)
    {
        # code...
        $ret="EEEE".$delivery;
        try {
            $ret=DB::table('ndeliveryid')->where('delivery_id',$delivery)->first()->ndelivery_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($delivery);
        }
        return $ret;
    }		
	
    public static function nD($discount)
    {
        # code...
        $ret="EEEE".$discount;
        try {
            $ret=DB::table('ndiscountid')->where('discount_id',$discount)->first()->ndiscount_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($discount);
        }
        return $ret;
    }	

    public static function nOw($ow)
    {
        # code...
        $ret="EEEE".$ow;
        try {
            $ret=DB::table('nopenwishid')->where('openwish_id',$ow)->first()->nopenwish_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($ow);
        }
        return $ret;
    }
	
    public static function nOc($oc)
    {
        # code...
        $ret="EEEE".$oc;
        try {
            $ret=DB::table('nocreditid')->where('ocredit_id',$oc)->first()->nocredit_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($oc);
        }
        return $ret;
    }	
	
    public static function nB($user_id)
    {
        # code...
        $ret="1";
       /* try {
            $ret=STR_PAD(DB::table('buyer')->where('user_id',$user_id)->first()->id,'11',"0",STR_PAD_LEFT);
        } catch (\Exception $e) {
			$ret= UC::nsid($user_id);
        }*/
        return $ret;
    }

    public static function nDO($deliveryorder_id)
    {
        # code...
        $ret="EEEE".$deliveryorder_id;
        try {
            $ret= DB::table('ndeliveryid')->where('deliveryorder_id',$deliveryorder_id)->first()->ndelivery_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($deliveryorder_id);
        }
        return $ret;
    }

    public static function nM($merchant_id)
    {
        # code...
        $ret="EEEE".$merchant_id;
        try {
			$merchant = DB::table('merchant')->where('id',$merchant_id)->first();
            $ret=DB::table('nsellerid')->where('user_id',$merchant->user_id)->first()->nseller_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($merchant_id);
        }
        return $ret;
    }
    public static function cN($merchant_id)
    {
        # code...
        $ret="EEEE".$merchant_id;
        try {
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
            $ret= $merchant->company_name;
        } catch (\Exception $e) {
            $ret= UC::nsid($merchant_id);
        }
        return $ret;
    }

    public static function nS($station_id)
    {
        # code...
        $ret="EEEE".$station_id;
        try {
            $station = DB::table('station')->where('id',$station_id)->first();
			if($station->stationtype_id == 1){
				$ret=DB::table('nsellerid')->where('user_id',$station->user_id)->first()->nseller_id;
			} else {
				$ret=DB::table('nsproviderid')->join('nsproviderlogisticid','nsproviderlogisticid.nsproviderid_id','=','nsproviderid.id')->join('logistic','nsproviderlogisticid.logistic_id','=','logistic.id')->where('logistic.station_id',$station_id)->first()->nsprovider_id;
			}
            
        } catch (\Exception $e) {
            $ret= UC::nsid($station_id);
        }
        return $ret;
    }
	
    public static function nSeller($user_id)
    {
        # code...
        $ret="EEEE".$user_id;
        try {
            $ret=DB::table('nsellerid')->where('user_id',$user_id)->first()->nseller_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($user_id);
        }
        return $ret;
    }
    public static function oSeller($user_id)
    {
        # code...
        $ret="0000".$user_id;
        try {
            $ret=DB::table('nsellerid')->where('user_id',$user_id)->first()->nseller_id;
        } catch (\Exception $e) {
            $ret= UC::osid($user_id);
        }
        return $ret;
    }

    public static function nState($state_id)
    {
        # code...
        $ret="EEEE".$state_id;
        try {
            $ret=DB::table('nstateid')->where('state_id',$state_id)->first()->nstate_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($state_id);
        }
        return $ret;
    }
    public static function nCountry($country_id)
    {
        # code...
        $ret="EEEE".$country_id;
        try {
            $ret=DB::table('ncountryid')->where('country_id',$country_id)->first()->ncountry_id;
        } catch (\Exception $e) {
            $ret=UC::nsid($country_id);
        }
        return $ret;
    }

    public static function nCity($city_id)
    {
        # code...
        $ret="EEEE".$city_id;
        try {
            $ret=DB::table('ncityid')->where('city_id',$city_id)->first()->ncity_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($city_id);
        }
        return $ret;
    }

    public static function nCre($cre_id)
    {
        try {
            $ret=DB::table('ncreid')->where('cre_id',$cre_id)->first()->ncre_id;
        } catch (\Exception $e) {
            $ret= UC::nsid($cre_id);
        }
        return $ret;
    }

    public static function nSMM($smmout_id)
    {
        try {
            $ret=DB::table('nsmmid')->where('smm_id',$smmout_id)->pluck('nsmm_id');
        } catch (\Exception $e) {
            $ret="LOL";
        }
        return $ret;
    }
}
