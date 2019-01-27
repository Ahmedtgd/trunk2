<?php namespace App\Classes;
use App\Exceptions\CustomException;
use QueryException;
use App\Http\Controllers\UtilityController;
use Carbon;
use DB;
class MsLinking{

    public function filterUrl(){
//        return route();
    }



    /**
     * Return all station and specific station if ID is provided
     * @param null $id
     * @return mixed
     * @throws CustomException
     */
    public function station($id=null)
    {
        try {
            $stations = DB::select("
            SELECT s.id, s.stationtype_id, s.scharacter, s.company_name as name, s.status as station_status, s.user_id,
            st.name as station_type, st.description as station_type_desc, adr.city_id as address_city_id, ci.country_code, ci.state_code,
            ci.name as city_name, ar.name as area_name, sta.name as state_name, c.name as country_name, ns.nseller_id as nstation_ida, ns.nseller_id as nstation_id,

				false as isEnabled
            FROM station s

            LEFT JOIN stationtype st ON s.stationtype_id = st.id
            LEFT JOIN address adr ON s.station_address_id = adr.id
            LEFT JOIN city ci ON adr.city_id = ci.id
            LEFT JOIN area ar ON adr.area_id = ar.id
            LEFT JOIN state sta ON ci.state_code = sta.code
            LEFT JOIN country c ON sta.country_code = c.code
			LEFT JOIN nsellerid ns ON s.user_id =  ns.user_id
			WHERE s.stationtype_id = 1
            ORDER BY s.id
        ");
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return $stations;
    }


    public function station_filter($merchant_id, $station_type_id, $station_character, $brands, $products, $oshops, $station_id)
    {
        try {
			$user_id = 0;
			$user = DB::table('merchant')->where('id',$merchant_id)->first();
			if(!is_null($user)){
				$user_id = $user->user_id;
			}
			$stype = "WHERE s.stationtype_id = 1 AND s.user_id != $user_id ";
			$lfjoin = "";
			if($station_type_id != ""){
				$stype = " WHERE s.stationtype_id = $station_type_id AND s.user_id != $user_id ";
				//if($station_character != ""){
				//	$stype .= " AND s.scharacter = '$station_character' "; 
				//}
			}/* else {
				if($station_character != ""){
				//	$stype .= " AND s.scharacter = '$station_character' "; 
				}
			}*/
			
			if($station_id != ""){
				$stype .= " AND s.id = $station_id ";
			}
			
			if($station_type_id == "" && $station_character == ""){
				if($brands != ""){
					$stype .= "AND prd.brand_id = $brands ";
					if($products != ""){
						$stype .= " AND prd.subcat_id = $products AND prd.subcat_level = 2 "; 
					}
				} else {
					if($products != ""){
						$stype .= " AND prd.id = $products AND prd.subcat_level = 2 "; 
					}
				}
				if($oshops != ""){
					$stype .= " AND oprd.oshop_id = $oshops ";
				}
			} else {
				if($brands != ""){
					$stype .= "AND prd.brand_id = $brands ";
					if($products != ""){
						$stype .= " AND prd.id = $products AND prd.subcat_level = 2 "; 
					}
				} else {
					if($products != ""){
						$stype .= " AND prd.id = $products AND prd.subcat_level = 2 "; 
					}
				}	
				if($oshops != ""){
					$stype .= " AND oprd.oshop_id = $oshops ";
				}
			}
			
			if($brands != "" || $products != "" || $oshops != ""){
				$lfjoin .= " JOIN stationsproduct as stp ON stp.station_id = s.id";
				$lfjoin .= " JOIN sproduct as sp ON stp.sproduct_id = sp.id ";
				$lfjoin .= " JOIN product as prd ON sp.product_id = prd.id ";
			}
			
			if($oshops != ""){
				$lfjoin .= " JOIN oshopproduct as oprd ON oprd.product_id = prd.id ";
			}
			
			if($merchant_id == ""){
				$merchant_id = 0;
			}
            $stations = DB::select("
            SELECT s.id, s.stationtype_id, s.scharacter, s.company_name as name, st.name as station_type, st.description as station_type_desc , st.description,
            c.name as country_name, adr.city_id as address_city_id, ci.country_code, ci.state_code, ci.name as city_name,
            ar.name as area_name, sta.name as state_name, s.user_id, ns.nseller_id as nstation_ida, ns.nseller_id as nstation_id,

                (
				    SELECT
                    au.visibility

				    FROM autolink au
                    WHERE s.user_id = au.initiator AND au.responder = $merchant_id AND au.sproperty_id IS NULL
				) as isEnabled,
				
                (
				    SELECT
                    case
                    	when au.status = 'linked' then true
                    	else false
                	end as status

				    FROM autolink au
                    WHERE s.user_id = au.initiator AND au.responder = $merchant_id AND au.sproperty_id IS NULL
				) as isLinked

            FROM station s
            LEFT JOIN stationtype st ON s.stationtype_id = st.id
            LEFT JOIN address adr ON s.station_address_id = adr.id
            LEFT JOIN city ci ON adr.city_id = ci.id
            LEFT JOIN area ar ON adr.area_id = ar.id
            LEFT JOIN state sta ON ci.state_code = sta.code
            LEFT JOIN country c ON sta.country_code = c.code
			LEFT JOIN nsellerid ns ON s.user_id =  ns.user_id
			" . $lfjoin . "
            " . $stype . "

            ORDER BY s.id
        ");
            //
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }
		//dd($stations);
        //lets include outlets
        if(is_array($stations))
        {
            foreach($stations as $key => $station)
            {
                $stations[$key]->outlets = $this->station_outlets($station->id, $merchant_id);
                $stations[$key]->isMerchantLinked = $this->isMerchantLinked($merchant_id, $station->user_id);
            }
        }

        return $stations;
    }


    public function isMerchantLinked($merchant_id, $station_user_id)
    {
        try {
            $auto_link =  DB::select("
            SELECT id
            FROM autolink au

            WHERE au.responder = $merchant_id
            AND au.initiator = $station_user_id
        ");
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return is_array($auto_link) ? count($auto_link) : 0;
    }

    /**
     * Returns all station_types
     * @param null $id
     * @return mixed
     * @throws CustomException
     */
    public function station_type($id=null)
    {
        try {
            $station_types = DB::select("
            SELECT st.id, st.name, st.description
            FROM stationtype st
        ");
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return $station_types;
    }

    /**
     * Returns all merchants
     * @param null $id
     * @return mixed
     * @throws CustomException
     */
    public function merchant($id=null)
    {
        try {
            $merchants =  DB::select("
            SELECT m.id, m.oshop_name as name,  m.company_name as company_name, nm.nseller_id as nmerchant_id
            FROM merchant m
			LEFT JOIN nsellerid nm ON m.user_id = nm.user_id
        ");
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return $merchants;
    }

    public function station_outlets($station_id, $merchant_id)
    {
        try {
		if($merchant_id == ""){
			$merchant_id = 0;
		}			
		 $station_single = DB::table('station')->where('id',$station_id)->first();
         $outlets = DB::select("
            SELECT sp.id as id, outlet_name as name, co.name as country_name, ci.name as city_name, ar.name as area_name,
				sta.name as state_name, s.scharacter, s.station_name as sname, s.status as station_status, s.user_id, nb.nbranch_id as nbranch_id,

				case
                    when sp.status = 'active' then true
                    else false
                end as isEnabled,

                (
				    SELECT
                    case
                    	when au.status = 'linked' then true
                    	else false
                	end as status

				    FROM autolink au
                    WHERE sp.id = au.sproperty_id AND au.responder = $merchant_id AND au.initiator = $station_single->user_id
				) as isLinked

            FROM sproperty sp

            LEFT JOIN address ad ON sp.address_id = ad.id
            LEFT JOIN station s ON sp.station_id = s.id
            LEFT JOIN city ci ON ad.city_id = ci.id
            LEFT JOIN area ar ON ad.area_id = ar.id
            LEFT JOIN state sta ON ci.state_code = sta.code
            LEFT JOIN country co ON ci.country_code = co.code
            LEFT JOIN nbranchoutletid nbo ON nbo.outlet_id = sp.id
            LEFT JOIN nbranchid nb ON nbo.nbranchid_id = nb.id

            WHERE sp.station_id = $station_id
        ");
        }catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return is_array($outlets) ? $outlets : null;
    }

    public function doEnable($stations, $spoutlets)
    {
        foreach($stations as $station)
        {
			// Checked or unchecked
            $status = $station->status ? 'active' : 'pending';
            DB::table('station')->
				where('id', '=', $station->station_id)->
				update(['status'=>$status]);
        }
		
        foreach($spoutlets as $spoutlet)
        {
			// Checked or unchecked
            $status = $spoutlet->status ? 'active' : 'pending';
            DB::table('sproperty')->
				where('id', '=', $spoutlet->station_id)->
				update(['status'=>$status]);
        }		
        return $this->station();
    }

    public function pEnable($dataenable){
		foreach($dataenable as $enable)
        {
			$status = $enable->status ? 1 : 0;
			$s_id = $enable->s_id;
			$u_id = $enable->u_id;
			if($status == 1){
				DB::table('productblacklist')->where('product_id',$s_id)->where('user_id',$u_id)->delete();
			} else {
				DB::table('productblacklist')->insert(['product_id'=>$s_id,'user_id'=>$u_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}
			
		}
		return "OK";
	}
    public function doAutolink($stations, $spoutlets,$stationsenable,$spoutletsenable, $merchant_id)
    {
		$now = Carbon::now();
		
        foreach($spoutlets as $spoutlet)
        {		
			try {
				$sp = DB::table('sproperty')->where('id',$spoutlet->station_id)->first();
				$station_o = DB::table('station')->where('id',$sp->station_id)->first();
			    $status = $spoutlet->status ? 'linked' : NULL;
                $al = DB::table('autolink')
                    ->where('initiator', '=', $station_o->user_id)
                    ->where('sproperty_id', '=', $spoutlet->station_id)
                    ->where('responder', '=', $merchant_id);
					
				if(!$status && $al->first()){
                    // If checkbox was not checked however this record has
					// already been inserted lets simply update the status
					//DB::table('dealer')->where('user_id',$station->user_id)->delete();
                    $al->update(['status'=>'unlinked']); //null

                } elseif($status && $al->first()){
                    // If checkbox was checked however this record already
					//$county = DB::table('dealer')->where('user_id',$station->user_id)->count();
					
                    $al->update(['status'=>$status]); //linked

                } elseif($status && !$al->first()){				
                    // This means this initiator does not exist nor linked
					// so lets insert it
					$link = DB::table('autolink')->insertGetId(['initiator'=>$station_o->user_id,'sproperty_id'=>$spoutlet->station_id,'responder'=>$merchant_id,'status'=>$status,'linked_since'=>date('Y-m-d H:i:s'),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					/*DB::insert("
					INSERT INTO autolink (initiator, sproperty_id,responder, status,
						linked_since, created_at, updated_at)
					VALUES (
						$station_o->user_id,
						$spoutlet->station_id,
						$merchant_id,
						'$status',
						CURRENT_TIMESTAMP(),
						CURRENT_TIMESTAMP(),
						CURRENT_TIMESTAMP()
					)
				    ");*/
					$newid = UtilityController::generaluniqueid($link, '2','2', date('Y-m-d H:i:s'));
					DB::table('nautolinkid')->insert(['nautolink_id'=>$newid, 'autolink_id'=>$link, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);	
					//dd($status);
                }					
			} catch(QueryException $e){
				throw new CustomException($e->getMessage());
			}
		}
		
        foreach($spoutletsenable as $spoutlet)
        {		
			try {
				$sp = DB::table('sproperty')->where('id',$spoutlet->station_id)->first();
				$station_o = DB::table('station')->where('id',$sp->station_id)->first();
			    $status = $spoutlet->status ? 1 : NULL;
                $al = DB::table('autolink')
                    ->where('initiator', '=', $station_o->user_id)
                    ->where('sproperty_id', '=', $spoutlet->station_id)
                    ->where('responder', '=', $merchant_id);
					
				if(!$status && $al->first()){
                    // If checkbox was not checked however this record has
					// already been inserted lets simply update the status
					//DB::table('dealer')->where('user_id',$station->user_id)->delete();
                    $al->update(['visibility'=>0]); //null

                } elseif($status && $al->first()){
                    // If checkbox was checked however this record already
					//$county = DB::table('dealer')->where('user_id',$station->user_id)->count();
					
                    $al->update(['visibility'=>1]); //linked

                } elseif($status && !$al->first()){				
                   /** This should not happen **/
                }					
			} catch(QueryException $e){
				throw new CustomException($e->getMessage());
			}
		}		
		
        foreach($stations as $station)
        {
			try {
				//checked or unchecked
                $status = $station->status ? 'linked' : NULL;
                $al = DB::table('autolink')
                    ->where('initiator', '=', $station->user_id)
                    ->whereNull('sproperty_id')
                    ->where('responder', '=', $merchant_id);

                if(!$status && $al->first()){
                    // If checkbox was not checked however this record has
					// already been inserted lets simply update the status
					DB::table('dealer')->where('user_id',$station->user_id)->delete();
                    $al->update(['status'=>'unlinked']); //null

                } elseif($status && $al->first()){
                    // If checkbox was checked however this record already
					$county = DB::table('dealer')->where('user_id',$station->user_id)->count();
					if($county <= 0){
						$county = DB::table('dealer')->insert(['user_id' => $station->user_id, 'updated_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')]);
					}
                    $al->update(['status'=>$status]); //linked

                } elseif($status && !$al->first()){
					$county = DB::table('dealer')->where('user_id',$station->user_id)->count();
					if($county <= 0){
						$county = DB::table('dealer')->insert(['user_id' => $station->user_id, 'updated_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')]);
					}					
                    // This means this initiator does not exist nor linked
					// so lets insert it
					$link = DB::table('autolink')->insertGetId(['initiator'=>$station->user_id,'responder'=>$merchant_id,'status'=>$status,'linked_since'=>date('Y-m-d H:i:s'),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                   /* DB::insert("
					INSERT INTO autolink (initiator, responder, status,
						linked_since, created_at, updated_at)
					VALUES (
						$station->user_id,
						$merchant_id,
						'$status',
						CURRENT_TIMESTAMP(),
						CURRENT_TIMESTAMP(),
						CURRENT_TIMESTAMP()
					)
				    ");*/
					$newid = UtilityController::generaluniqueid($link, '2','2', date('Y-m-d H:i:s'), 'nautolinkid', 'nautolink_id');
					DB::table('nautolinkid')->insert(['nautolink_id'=>$newid, 'autolink_id'=>$link, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);	
                }

			} catch(QueryException $e){
				throw new CustomException($e->getMessage());
			}

			try {
                // Ensure no duplicate so insert if not exists
                if(!DB::table('dealer')->where('user_id', '=',
					$station->user_id)->first())
                {
                    DB::insert("
                        INSERT INTO dealer (user_id, created_at, updated_at)
                        VALUES($station->user_id,'$now','$now')
                        ON DUPLICATE KEY UPDATE id=id
				    ");
                }
			} catch(QueryException $e){
				throw new CustomException($e->getMessage());
			}
        }
		
        foreach($stationsenable as $station)
        {
			try {
				//checked or unchecked
                $status = $station->status ? 1 : NULL;
                $al = DB::table('autolink')
                    ->where('initiator', '=', $station->user_id)
                    ->whereNull('sproperty_id')
                    ->where('responder', '=', $merchant_id);

                if(!$status && $al->first()){
                    // If checkbox was not checked however this record has
					// already been inserted lets simply update the status
                    $al->update(['visibility'=>0]); //null

                } elseif($status && $al->first()){
                    // If checkbox was checked however this record already
					$county = DB::table('dealer')->where('user_id',$station->user_id)->count();
					if($county <= 0){
						$county = DB::table('dealer')->insert(['user_id' => $station->user_id, 'updated_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')]);
					}
                    $al->update(['visibility'=>1]); //linked

                } elseif($status && !$al->first()){
					/*** This should not happen ***/
                }

			} catch(QueryException $e){
				throw new CustomException($e->getMessage());
			}
        }		

        return $this->station();
    }
}
