<?php
namespace App\Classes;

use DB;
use App\Exceptions\CustomException;
use QueryException;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\NinjaVanController as NV;
use App\Models\Product;
use App\Models\Merchant;

class Delivery {

    public function calculate_price($weight, $length, $width,
		$height,$del_option,$merchant_id = 0,$quantity=1){

		$lc = new LogisticsController;
		
		/* Trying to be as generic as possible */
		$logistic_id=$lc->select_logistic_id($lc->select_logistic());;


		$global = DB::table('global')->first();
		$volfactor=$global->volfactor;
		if($del_option == "system" || $del_option == "own"){
			if($del_option == "own" && $merchant_id == 0){
				return 0;
			} else {
				/*
				dump('merchant_id ='.$merchant_id);
				dump('del_option  ='.$del_option);
				*/

				if($merchant_id > 0 && $del_option == "own"){
					$merchant = DB::table('merchant')->
						where('id',$merchant_id)->first();

					if(!is_null($merchant)){
						$logistic = DB::table('logistic')->
							join('station','logistic.station_id','=',
								'station.id')->
							where('station.user_id',$merchant->user_id)->
							select('logistic.id as lid')->first();

						if(!is_null($logistic)){
							$logistic_id = $logistic->lid;
						}
					}
				}
				$weight=$weight*$quantity;
				
				$price = 0;
				$vweight = 0; // volumetric weight
				$weight = ($weight * 1000 ) * 1.1;

				$slab = DB::table('slab')->
					where('logistic_id', $logistic_id)->
					where('weight','<=',$weight)->
					where('weight','>', 0)->
					orderBy('base_price','DESC')->first();
				
				/* Less than the smallest weight */
				if(empty($slab)){
					$slab = DB::table('slab')->
						where('logistic_id', $logistic_id)->
						where('weight','>', 0)->
						orderBy('base_price','ASC')->first();
				}else{
					/*Get the next slab*/
					
					$nslab = DB::table('slab')->
					where('logistic_id', $logistic_id)->
					where('weight','>',$slab->weight)->
					
					orderBy('base_price','ASC')->first();
					if (!empty($nslab)) {
						$slab=$nslab;
					}
				}
				
				// Get merchant's volfactor.
				try {
					$lrec=DB::table('logistic')->
						where('id',$logistic_id)->first();
					$volfactor = $lrec->volfactor;

					//Will create an exception if $volfactor -0 
					$test=1/$volfactor; 

				} catch (\Exception $e) {
					$volfactor=$global->volfactor;
				}

				if(!is_null($slab)){
					$vweight = ($length * $width * $height)/$volfactor;

					/*
					dump("weight=".$weight);
					dump("vweight=".$vweight);
					*/

					/* If volumetric weight is greater than physical weight,
					 * we use that instead */
					//echo "weight after *1.1 ".$weight;
					if ($vweight > $weight) {
						$weight = $vweight;
					//	echo "Taking volumetric weight ".$vweight ;
					}

					
					if($weight < $slab->weight){
						$price = $slab->base_price;

					} else {

						if($slab->incremental_unit > 0){
							$witerval = round($weight/$slab->incremental_unit);
							//dump('witerval='.$witerval);

							$biterval = round($slab->weight/$slab->incremental_unit);
							//dump('biterval='.$biterval);

							$adprice = $slab->incremental_price * ($witerval - $biterval);
							//dump('adprice='.$adprice);
							$price = ($slab->base_price + $adprice);

						} else {
							$price = $slab->base_price;
						}
					} 
				}
				//dump('price='.$price);

                /* Getting the logistic provider's commission
				 * to OpenSupermall */
				$lcomm=$lrec->logistic_commission;
				if (is_null($lcomm) || empty($lcomm)) {
					$lcomm = $global->logistic_commission;
				}

                /* Getting the logistic provider's surcharge
				 * to OpenSupermall. ZERO is valid, like NinjaVan */
				$lscharge=$lrec->surcharge;
				if (is_null($lscharge)) { 
					$lscharge = $global->ctl_surcharge;
				}
 
				/*
				dump('gst='.$global->gst_rate);
				dump('lcomm='.$lcomm);
				dump('lscharge='.$lscharge);
				*/

				/* Total price is slab plus surcharge */
				$ret = $price * (1 +
					($lscharge + $global->gst_rate + $lcomm)/100);

				//dump('ret='.$ret);

				return $ret;
			}

		} else {
			return 0;
		}
	}

	/*
		The Delivery is per the product now , as talked with UJ on 3rd of Aug,20177
	*/ 
	public function get_delivery_price($product_id,$quantity,$waiver=True)
	{
		$ret=0;
		$product=Product::find($product_id);
		if (!is_null($product)) {
			if($product->segment == 'b2b'){
				$delivery_mode="pick-up";
				$merchant_id=UtilityController::productMerchantId($product->id);
				$merchant=Merchant::find($merchant_id);

				/*Select Delivery mode*/ 
				
					if ($merchant->all_own_delivery==True and $merchant->all_system_delivery==False) {
						$delivery_mode="own";
					}elseif ($merchant->all_system_delivery==True and $merchant->all_own_delivery==False) {
						$delivery_mode="system";
					}else{
						if (isset($product->del_option) and !is_null($product->del_option)) {
							$delivery_mode=$product->del_option;
						}
					}
				
				// dump($delivery_mode);
				/*Select the appropriate delivery calculation formula*/ 
				Log::info("delivery_mode for ".$product->id,$delivery_mode);
				switch ($delivery_mode) {

					case 'system':
						$ret=$this->calculate_price($product->weight,$product->length,$product->width,$product->height,$product->del_option, $merchant_id,$quantity);
						break;
					case 'own':
						if (!is_null($product->flat_delivery) and $product->flat_delivery!=0 ) {
							$ret=$product->b2b_del_west_malaysia; 
						}else{
							$ret=$product->b2b_del_west_malaysia*$quantity;
						}
						break;
					case 'pickup':
						$ret=0;
						break;
					default:
						$ret=0;
						break;
				}

				// if ($merchant->all_system_delivery==1) {
				// 	/**/ 

				// 	$ret=$this->calculate_price($product->weight,$product->length,$product->width,$product->height,$product->del_option, $merchant_id)*$quantity;

				// }
				// elseif ($merchant->all_own_delivery==True and $merchant->all_system_delivery==False) {
					
				// 	if (!is_null($product->flat_delivery) and $product->flat_delivery!=0 ) {
						
				// 		/*Flat Delivery*/
				// 		$ret=$product->del_west_malaysia; 
				// 	}else{
				// 		$ret=$product->del_west_malaysia*$quantity;
				// 	}
				// }
				if (!is_null($product->free_delivery) and $product->free_delivery>0){
					$ret=0;
				}
				$wholesales = DB::table('wholesale')->where('product_id',$product->id)->where('funit','<=',$quantity)->orderBy('funit','DESC')->first();
				$price = 0;
				if(!is_null($wholesales)){
					$price = $wholesales->price;
				}
				/*Check for delivery waiver*/
				if (!is_null($product->free_delivery_with_purchase_amt) and $product->free_delivery_with_purchase_amt>0 and $waiver==True) {
					/*Get the price*/
					$total_price=$price*$quantity;
					if ($total_price>=$product->free_delivery_with_purchase_amt) {
						$ret=0;
					 } 
				}				
			}
			if($product->segment == 'b2c'){
				$delivery_mode="pick-up";
				$merchant_id=UtilityController::productMerchantId($product->id);
				$merchant=Merchant::find($merchant_id);

				/*Select Delivery mode*/ 
				
					if ($merchant->all_own_delivery==True and $merchant->all_system_delivery==False) {
						$delivery_mode="own";
					}elseif ($merchant->all_system_delivery==True and $merchant->all_own_delivery==False) {
						$delivery_mode="system";
					}else{
						if (isset($product->del_option) and !is_null($product->del_option)) {
							$delivery_mode=$product->del_option;
						}
					}
				
				// dump($delivery_mode);
				/*Select the appropriate delivery calculation formula*/ 
				switch ($delivery_mode) {
					case 'system':
						$ret=$this->calculate_price($product->weight,$product->length,$product->width,$product->height,$product->del_option, $merchant_id,$quantity);
						break;
					case 'own':
						if (!is_null($product->flat_delivery) and $product->flat_delivery!=0 ) {
							$ret=$product->del_west_malaysia; 
						}else{
							$ret=$product->del_west_malaysia*$quantity;
						}
						break;
					case 'pickup':
						$ret=0;
						break;
					default:
						$ret=999999;
						break;
				}

				// if ($merchant->all_system_delivery==1) {
				// 	/**/ 

				// 	$ret=$this->calculate_price($product->weight,$product->length,$product->width,$product->height,$product->del_option, $merchant_id)*$quantity;

				// }
				// elseif ($merchant->all_own_delivery==True and $merchant->all_system_delivery==False) {
					
				// 	if (!is_null($product->flat_delivery) and $product->flat_delivery!=0 ) {
						
				// 		/*Flat Delivery*/
				// 		$ret=$product->del_west_malaysia; 
				// 	}else{
				// 		$ret=$product->del_west_malaysia*$quantity;
				// 	}
				// }
				if (!is_null($product->free_delivery) and $product->free_delivery>0){
					$ret=0;
				}

				/*Check for delivery waiver*/
				if (!is_null($product->free_delivery_with_purchase_amt) and $product->free_delivery_with_purchase_amt>0 and $waiver==True) {
					/*Get the price*/
					$price=$product->discounted_price>0?$product->discounted_price:$product->retail_price;
					$total_price=$price*$quantity;
					if ($total_price>=$product->free_delivery_with_purchase_amt) {
						$ret=0;
					 } 
				}
			}
		}
		
		return $ret;
	}
	
	public function get_delivery_price_b2b($product_id,$quantity,$price,$waiver=True)
	{
		$ret=0;
		$product=Product::find($product_id);
		if (!is_null($product)) {
			$delivery_mode="pick-up";
			$merchant_id=UtilityController::productMerchantId($product->id);
			$merchant=Merchant::find($merchant_id);

			/*Select Delivery mode*/ 
			
				if ($merchant->all_own_delivery==True and $merchant->all_system_delivery==False) {
					$delivery_mode="own";
				}elseif ($merchant->all_system_delivery==True and $merchant->all_own_delivery==False) {
					$delivery_mode="system";
				}else{
					if (isset($product->del_option) and !is_null($product->del_option)) {
						$delivery_mode=$product->del_option;
					}
				}
			
			// dump($delivery_mode);
			/*Select the appropriate delivery calculation formula*/ 
			switch ($delivery_mode) {
				case 'system':
					$ret=$this->calculate_price($product->weight,$product->length,$product->width,$product->height,$product->del_option, $merchant_id)*$quantity;
					break;
				case 'own':
					if (!is_null($product->flat_delivery) and $product->flat_delivery!=0 ) {
						$ret=$product->b2b_del_west_malaysia; 
					}else{
						$ret=$product->b2b_del_west_malaysia*$quantity;
					}
					break;
				case 'pickup':
					$ret=0;
					break;
				default:
					$ret=999999;
					break;
			}

			// if ($merchant->all_system_delivery==1) {
			// 	/**/ 

			// 	$ret=$this->calculate_price($product->weight,$product->length,$product->width,$product->height,$product->del_option, $merchant_id)*$quantity;

			// }
			// elseif ($merchant->all_own_delivery==True and $merchant->all_system_delivery==False) {
				
			// 	if (!is_null($product->flat_delivery) and $product->flat_delivery!=0 ) {
					
			// 		/*Flat Delivery*/
			// 		$ret=$product->del_west_malaysia; 
			// 	}else{
			// 		$ret=$product->del_west_malaysia*$quantity;
			// 	}
			// }
			if (!is_null($product->free_delivery) and $product->free_delivery>0){
				$ret=0;
			}

			/*Check for delivery waiver*/
			if (!is_null($product->free_delivery_with_purchase_amt) and $product->free_delivery_with_purchase_amt>0 and $waiver==True) {
				/*Get the price*/
				$total_price=$price*$quantity;
				if ($total_price>=$product->free_delivery_with_purchase_amt) {
				 	$ret=0;
				 } 
			}
		}
		/*$ret should be rounded of to two decimal places*/
		$ret=round($ret,2);
		return $ret;
	}	
}
