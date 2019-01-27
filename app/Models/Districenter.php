<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;


class Districenter extends Model
{
    protected $table = 'districenter';

    protected $fillable = [
        'capacity',
        'dc_name',
        'capacity',
        'parcel',
        'container',
        'palette',
        'perishable',
        'address_id',
        'station_id'
    ];


    /*Property has only one station 1:1*/
    public function station()
    {
        return $this->hasOne('App\Models\Station','id','station_id');
    }

    public function getMeta()
    {
        return[
            "id" => null,
            "capacity" => null,
            "dc_name" => null,
            "parcel" => null,
            "container" => null,
            "outlet_id" => null,
            "palette" => null,
            "perishable" => null,
            "station_id" => null,
            "address_id" => null
        ];
    }

    public static function store(Request $request, $id)
    {
        $distributioncenter = new Districenter();
        $user_data = $distributioncenter->collectDistricenterFormData($request, $id);
		$length = count($request->get('dc_name'));
		$property_model[] = null;
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
					'dc_name'=>$user_data['dc_name'][$i],
				/*	'capacity'=>$user_data['capacity'][$i],
					'parcel'=>$user_data['parcel'][$i],
					'container' => $user_data['container'][$i],
					'perishable'=>$user_data['perishable'][$i],
					'palette'=>$user_data['palette'][$i],*/
					'station_id'=>$id,		
					'address_id'=>$address_id		
				];		
				$newProperty = $distributioncenter->create($record);
				$property_model[] = $newProperty;			
				//$property_model = $property->create($user_data);
			}
		}		
        

        return $property_model;
    }

    public function collectDistricenterFormData(Request $request, $id)
    {
        return  $user_data = [
            'dc_name'=>$request->get('dc_name'),
          /*  'capacity'=>$request->get('capacity'),
            'parcel' => $request->get('real_parcel'),
            'container'=>$request->get('real_container'),
            'palette'=>$request->get('real_palette'),
            'perishable'=>$request->get('real_perishable'),*/
            'city_idst'=>$request->get('city_idst'),
            'outlet_line1'=>$request->get('outlet_line1'),
            'outlet_line2'=>$request->get('outlet_line2'),
            'outlet_line3'=>$request->get('outlet_line3'),
            'outlet_line4'=>$request->get('outlet_line4'),
            'zipcode'=>$request->get('zipcode')

        ];
    }

    public function UpdateDistricenter($request,$station_data){
        $id = $station_data->id;
        $property = Sproperty::where('station_id', $id)->first();
        if (is_null($property)) {
            return 0;
        }
        else{
            $property->biz_name = $request->get('name_business');
            $property->outlet_name = $request->get('outlet_name');
            $property->biz_owner_contact = $request->get('contact_business');
            $property->biz_owner_first_name = $request->get('firstname_business');
            $property->biz_owner_last_name = $request->get('lastname_business');
            $property->outlet_id = $request->get('outlet_business');
            $property->prop_owner_contact = $request->get('contact_property');
            $property->prop_owner_first_name = $request->get('firstname_property');
            $property->prop_owner_last_name = $request->get('lastname_property');
            $property->shop_size = $request->get('shop_size');

            return $property->save();
        }

    }

}
