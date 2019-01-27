<?php namespace App\Classes;

use DB;
use App\Exceptions\CustomException;
use QueryException;
use Cart;

class StationIntelligence{

	/* use use App\Classes\SecurityIDGenerator;
	 * $a = new SecurityIDGenerator;
	 * $a->generate("2016-12-05");
	 * $a->generate(Carbon::now()->toDateString());
	 */



	public function get_station($address, $contents){
		$limit = 5;
		$days = 90;
		$station_picked = 0;
		$date = date('Y-m-j H:i:s');
		$newdate = strtotime ( '-' . $days .' day' , strtotime ( $date ) ) ;
		$newdate = date ( 'Y-m-j H:i:s' , $newdate );
		$stations = null;
		// return $address->area_id;
		if(!is_null($address)){
			if(!is_null($address->area_id)){
				$sqlselect = "SELECT DISTINCT (station.id) as id,(((acos(sin((address.latitude*pi()/180)) * 
					sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
					cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
					pi()/180))))*180/pi())*60*1.1515
				) as distance, SUM(st.fair_commission) as fair_commission_sum ";
				$sqlfrom = " FROM station, address ";
				$sqlwhere = " WHERE (station.station_address_id  = address.id AND address.area_id = " . $address->area_id . ")";
				$sqlorder = " ORDER BY distance, CASE fair_commission_sum WHEN 0 THEN 10000000 WHEN NULL THEN 10000000 ELSE fair_commission_sum END ASC, station.created_at LIMIT " . $limit; 
				$k=0;
				foreach ($contents as $l) {
					$item=$l;
					$k++;
					// echo $item->quantity;
					$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . ", product as product" . $k . " ";
					$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = product" . $k . ".id AND product" . $k . ".parent_id = " . $item->id . " AND product" . $k . ".segment = 'b2b' AND sproduct" . $k . ".available >= " . $item->quantity . " AND sproduct" . $k . ".stock > 0 ";
				}

				$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

				$stations = DB::select(DB::raw($sqltotal));
			}
			$arrstations = array();
			$arrsums = array();
			// dump($stations);
			if(sizeof($stations) != 0){

				$k=0;
				$sum = 10000;
				
				foreach ($stations as $st) {
					$station = null;
					$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " ORDER BY created_at DESC LIMIT 1"));
					foreach ($stationsum as $sum) {
						$station = $sum->created_at;
					}
					if(!is_null($station)){
						$arrstations[$k] = $st->id;
						$arrsums[$k] = $station;
						$k++;
					} else {
						$station_picked = $st->id;
						break;
					}
					$sum--;
				}
			
				if($station_picked == 0){
					$least_ammount = 1988121600;
					$least_id = 0;
					for($i=0;$i<$limit;$i++){
						if(strtotime($arrsums[$i])<$least_ammount){
							$least_ammount = $arrsums[$i];
							$least_id = $arrstations[$i];
						}
					}
					$station_picked = $least_id;
				}
			} else {
				if(!is_null($address->city_id)){
					$sqlselect = "SELECT DISTINCT (station.id),(((acos(sin((address.latitude*pi()/180)) * 
					sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
					cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
					pi()/180))))*180/pi())*60*1.1515
				) as distance ";
					$sqlfrom = " FROM station, address ";
					$sqlwhere = " WHERE (station.station_address_id  = address.id AND address.city_id = " . $address->city_id . ")";
					$sqlorder = " ORDER BY distance, fair_commission_sum DESC, station.osmall_commission DESC, station.created_at ";
					$k=0;
					foreach ($contents as $item) {
						$item=Cart::item($l);
						$k++;
						$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . ", product as product" . $k . " ";
						$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = product" . $k . ".id AND product" . $k . ".parent_id = " . $item->id . " AND product" . $k . ".segment = 'b2b' AND sproduct" . $k . ".available >= " . $item->quantity . " AND sproduct" . $k . ".stock > 0 ";
					}

					$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

					$stations = DB::select(DB::raw($sqltotal));
				}
				$arrstations = array();
				$arrsums = array();
				if(!is_null($stations)){
					$k=0;
					$sum = 10000;
					foreach ($stations as $st) {
						$station = null;
						$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " ORDER BY created_at DESC LIMIT 1"));
						foreach ($stationsum as $sum) {
							$station = $sum->created_at;
						}
						if(!is_null($station)){
							$arrstations[$k] = $st->id;
							//$getsum = DB::select(DB::raw("SELECT SUM(orderproduct.order_price * orderproduct.quantity) as suma FROM orderproduct, porder, sorder WHERE orderproduct.porder_id = porder.id AND porder.id = sorder.porder_id AND sorder.station_id = " . $st->id));
							$arrsums[$k] = $station;
							$k++;
						} else {
							$station_picked = $st->id;
							break;
						}
						$sum--;
					}
					if($station_picked == 0){
						$least_ammount = 1000000000;
						$least_id = 0;
						for($i=0;$i<$limit;$i++){
							if($arrsums[$i]<$least_ammount){
								$least_ammount = $arrsums[$i];
								$least_id = $arrstations[$i];
							}
						}
						$station_picked = $least_id;
					}
					$k=0;
					$sum = 10000;
					foreach ($stations as $st) {
						$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " AND created_at > '" . $newdate . "'"));
						foreach ($stationsum as $sum) {
							$station = $sum->id;
						}
						if(!is_null($station)){
							$arrstations[$k] = $st->id;
							$arrsums[$k] = $sum;
							$k++;
						} else {
							$station_picked = $st->id;
							break;
						}
						$sum--;
					}
					if($station_picked == 0){
						$least_ammount = 1988121600;
						$least_id = 0;
						for($i=0;$i<$limit;$i++){
							if(strtotime($arrsums[$i])<$least_ammount){
								$least_ammount = $arrsums[$i];
								$least_id = $arrstations[$i];
							}
						}
						$station_picked = $least_id;
					}
				}
			}
		}

		return $station_picked;
	}
	/*
		@params: (object) porder,address 
		@outputs: KeyValue array. station=>orderproduct_id
		@author: Zurezster!

	*/ 
	public function assigned_stations($porder,$address)
	{
		$ret= array();
		$limit=5;
		if (is_null($porder)  or is_null($address) or !isset($address)) {
			return $ret;
		}
		// Get all the stations for the merchant.
		try {
			$ret=DB::select(DB::raw(
				'
				SELECT 
				DISTINCT (station.id) as id,
				(((acos(sin((address.latitude*pi()/180)) * 
					sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
					cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
					pi()/180))))*180/pi())*60*1.1515
				) as distance
				FROM 
				station, address, sproperty
				WHERE 
				(station.id = sproperty.station_id AND sproperty.address_id = address.id AND address.area_id = " . $address->area_id . ") OR (station.station_address_id  = address.id AND address.area_id = " . $address->area_id . ")
				ORDER BY distance, station.created_at 
				LIMIT "$limit"

				'

				));
		} catch (\Exception $e) {
			dump($e);
		}
		return $ret;
	}
}
