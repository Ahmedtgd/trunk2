<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\UtilityController;
use DB;

class Sproperty extends Model
{
    protected $table = 'sproperty';

    protected $fillable = [
        'biz_name',
        'outlet_name',
        'biz_owner_contact',
        'biz_owner_first_name',
        'biz_owner_last_name',
        'outlet_id',
        'address_id',
        'prop_owner_contact',
        'prop_owner_first_name',
        'prop_owner_last_name',
        'shop_size',
        'delivery_mode',
        'station_id'
    ];


    /*Property has only one station 1:1*/
    public function station()
    {
        return $this->hasOne('App\Models\Station','id','station_id');
    }

    public function outlet()
    {
        return $this->hasOne('App\Models\Outlet','id','outlet_id');
    }

    public function getMeta()
    {
        return[
            "id" => null,
            "biz_name" => null,
            "biz_owner_contact" => null,
            "biz_owner_first_name" => null,
            "biz_owner_last_name" => null,
            "outlet_id" => null,
            "prop_owner_contact" => null,
            "prop_owner_first_name" => null,
            "prop_owner_last_name" => null,
            "delivery_mode" => null,
            "shop_size" => null,
            "station_id" => null,
            "address_id" => null
        ];
    }

    public static function store(Request $request, $id)
    {
        $property = new Sproperty();
        $user_data = $property->collectPropertyFormData($request, $id);
		$length = count($request->get('shop_size'));
        for($i=0;$i<$length;$i++)
        {
			if($user_data['city_idst'][$i] == "" || is_null($user_data['city_idst'][$i])){
				$property_model[] = "";	
			} else {
				$station_address = new Address();
				$station_address->city_id = $user_data['city_idst'][$i];
				$station_address->postcode = $user_data['zipcode'][$i];
				$station_address->line1 = $user_data['outlet_line1'][$i];
				$station_address->line2 = $user_data['outlet_line2'][$i];
				$station_address->line3 = $user_data['outlet_line3'][$i];
				$station_address->line4 = $user_data['outlet_line4'][$i];
				$station_address->type = 'default';
				$address_id =  0;
				if ($station_address->save()) {
					$address_id=$station_address->id;
				}
				$record = [
					'biz_name'=>$user_data['biz_name'][$i],
					'outlet_name'=>$user_data['outlet_name'][$i],
					'biz_owner_contact'=>$user_data['biz_owner_contact'][$i],
					'biz_owner_first_name' => $user_data['biz_owner_first_name'][$i],
					'biz_owner_last_name'=>$user_data['biz_owner_last_name'][$i],
					'outlet_id'=>$user_data['outlet_id'][$i],
					'prop_owner_contact'=>$user_data['prop_owner_contact'][$i],
					'prop_owner_first_name'=>$user_data['prop_owner_first_name'][$i],
					'prop_owner_last_name'=>$user_data['prop_owner_last_name'][$i],
					'shop_size'=>$user_data['shop_size'][$i],
					'delivery_mode'=>$user_data['delivery_mode'][$i],
					'station_id'=>$id,		
					'address_id'=>$address_id		
				];
							
					$newProperty = $property->create($record);
					$property_model[] = $newProperty;	
					$uniqueid = (new UtilityController)->branchuniqueid($user_data['city_idst'][$i],'07');
				//	DB::table('nbranchid')->insert(['nbranch_id'=>$uniqueid, 'outlet_id' => $newProperty->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);			
					if($uniqueid != ""){
							$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							
							DB::table('nbranchoutletid')->insertGetId(['nbranchid_id'=>$nbid, 'outlet_id'=>$newProperty->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
			}
		}		
        

        return $property_model;
    }

    public function collectPropertyFormData(Request $request, $id)
    {
        return  $user_data = [
            'biz_name'=>$request->get('biz_name'),
            'outlet_name'=>$request->get('outlet_name'),
            'biz_owner_contact'=>$request->get('biz_owner_contact'),
            'biz_owner_first_name' => $request->get('biz_owner_first_name'),
            'biz_owner_last_name'=>$request->get('biz_owner_last_name'),
            'outlet_id'=>$request->get('outlet_business'),
            'prop_owner_contact'=>$request->get('contact_property'),
            'prop_owner_first_name'=>$request->get('firstname_property'),
            'prop_owner_last_name'=>$request->get('lastname_property'),
            'shop_size'=>$request->get('shop_size'),
            'delivery_mode'=>$request->get('delivery_business'),
            'city_idst'=>$request->get('city_idst'),
            'outlet_line1'=>$request->get('outlet_line1'),
            'outlet_line2'=>$request->get('outlet_line2'),
            'outlet_line3'=>$request->get('outlet_line3'),
            'outlet_line4'=>$request->get('outlet_line4'),
            'sproperty_id'=>$request->get('outlet_id'),
            'zipcode'=>$request->get('zipcode')

        ];
    }

    public function UpdateProperty($request,$id){
        $property = new Sproperty();
        $user_data = $property->collectPropertyFormData($request, $id);
		//dd($user_data);
		$length = count($request->get('shop_size'));
        for($i=0;$i<$length;$i++)
        {
			if($user_data['city_idst'][$i] == "" || is_null($user_data['city_idst'][$i])){
				$property_model[] = "";	
			} else {
				$property = new Sproperty();
				$station_address = new Address();
				$station_address->city_id = $user_data['city_idst'][$i];
				$station_address->postcode = $user_data['zipcode'][$i];
				$station_address->line1 = $user_data['outlet_line1'][$i];
				$station_address->line2 = $user_data['outlet_line2'][$i];
				$station_address->line3 = $user_data['outlet_line3'][$i];
				$station_address->line4 = $user_data['outlet_line4'][$i];
				$station_address->type = 'default';
				$address_id =  0;
				if ($station_address->save()) {
					$address_id=$station_address->id;
				}
				$record = [
					'biz_name'=>$user_data['biz_name'][$i],
					'outlet_name'=>$user_data['outlet_name'][$i],
					'biz_owner_contact'=>$user_data['biz_owner_contact'][$i],
					'biz_owner_first_name' => $user_data['biz_owner_first_name'][$i],
					'biz_owner_last_name'=>$user_data['biz_owner_last_name'][$i],
					'outlet_id'=>$user_data['outlet_id'][$i],
					'prop_owner_contact'=>$user_data['prop_owner_contact'][$i],
					'prop_owner_first_name'=>$user_data['prop_owner_first_name'][$i],
					'prop_owner_last_name'=>$user_data['prop_owner_last_name'][$i],
					'shop_size'=>$user_data['shop_size'][$i],
					'delivery_mode'=>$user_data['delivery_mode'][$i],
					'station_id'=>$id,		
					'address_id'=>$address_id		
				];		
				if($user_data['sproperty_id'][$i] == 0){
					$newProperty = $property->create($record);
					$property_model[] = $newProperty;	
					$uniqueid = (new UtilityController)->branchuniqueid($user_data['city_idst'][$i],'07');
				//	DB::table('nbranchid')->insert(['nbranch_id'=>$uniqueid, 'outlet_id' => $newProperty->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);			
					if($uniqueid != ""){
							$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							
							DB::table('nbranchoutletid')->insertGetId(['nbranchid_id'=>$nbid, 'outlet_id'=>$newProperty->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}				
				} else {
					$property = Sproperty::find($user_data['sproperty_id'][$i]);
					$property->update($record);
					$property_model[] = $property;
				}
			}

		}		
        

        return $property_model;

    }

}
