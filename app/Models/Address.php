<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Address extends Model
{
    protected $table = 'address';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /*starts relations*/

    /*Address has only one merchant 1:1*/
    public function merchant()
    {
        return $this->hasOne('App\Models\Merchant','address_id','id');
    }

    /*Address has only one station 1:1*/
    public function station()
    {
        return $this->hasOne('App\Models\Station','address_id','id');
    }

    /*Address belongs to only one city 1:1*/
    public function get_city()
    {
        return $this->hasOne('App\Models\City','id','city_id');
    }
    /*Address belongs to only one area 1:1*/
    public function get_area()
    {
        return $this->hasOne('App\Models\Area','id','area_id');
    }
    /*end relations*/

    public function getMeta()
    {
        return  [ "id" => null,
            "city_id" =>null,
            "area_id"=>null,
            "postcode" => null,
            "line1" => null,
            "line2" => null,
            "line3" => null,
            "line4" => null,
            "latitude" => null,
            "longitude" => null,
            "type" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null,
        ];
    }	
	
    public function store(Request $request)
    {
        $address_data = $this->collectAddressFormData($request);
        
        $address = new Address();
        $address_model = $address->create($address_data);

        return $address_model;
    }

    public function collectAddressFormData(Request $request )
    {
        return  $bank_data = [
            'city_id'=>$request->get('city_id'),
            'postcode'=>$request->get('zip'),
            'line1'=>$request->get('line1'),
            'line2'=>$request->get('line2'),
            'line3'=>$request->get('line3'),
            'line4'=>$request->get('line4'),
            'type'=>'default'
        ];
    }
	
    public function storelatlong(Request $request)
    {
        $address_data = $this->collectAddressFormDatalatlong($request);
        
        $address = new Address();
        $address_model = $address->create($address_data);

        return $address_model;
    }	
	
    public function collectAddressFormDatalatlong(Request $request )
    {
        return  $bank_data = [
            'city_id'=>$request->get('city_id'),
            'postcode'=>$request->get('zip'),
            'line1'=>$request->get('line1'),
            'line2'=>$request->get('line2'),
            'line3'=>$request->get('line3'),
            'line4'=>$request->get('line4'),
            'latitude'=>$request->get('geoip_lat'),
            'longitude'=>$request->get('geoip_lon'),
            'type'=>'default'
        ];
    }	

    public function UpdateAddress($request,$merchant_data){
        $data = $merchant_data->id;
		$address = Address::find($merchant_data->address_id);

		if(!is_null($address)){
			$address->city_id = $request->get('city_id');
			$address->area_id = $request->get('area_id');
			$address->postcode = $request->get('zip');
			$address->line1 = $request->get('line1');
			$address->line2 = $request->get('line2');
			$address->line3 = $request->get('line3');
			$address->line4 = $request->get('line4');
			$address->save();

		} else {
			// We don't have an existing address!!
			$address_data = $this->collectAddressFormData($request);
			$naddr = new Address();
			$address = $naddr->create($address_data);
			$address->save();

			// We have to update $merchant->address_id = $address->id 
			$merchant_id = $merchant_data->id;
			$address_id = $address->id;
		}

        // Apparently $data is the merchant or station id here. ~Zurez
        $ret= $address->id; 
        return $ret;
    }
	
    public function UpdateAddress2($request,$merchant_data){

        $data = $merchant_data->id;
        $address = Address::find($merchant_data->oshop_address_id);
		if(!is_null($address)){
			$address->city_id = $request->get('mcity_id');
			$address->area_id = $request->get('marea_id');
			$address->postcode = $request->get('mzip');
			$address->line1 = $request->get('sline1');
			$address->line2 = $request->get('sline2');
			$address->line3 = $request->get('sline3');
			$address->line4 = $request->get('sline4');

			return $address->save();
		} else {
			$merchant_address = new Address();
			$merchant_address->city_id = $request->get('mcity_id');
			$merchant_address->postcode = $request->get('mzip');
			$merchant_address->line1 = $request->get('sline1');
			$merchant_address->line2 = $request->get('sline2');
			$merchant_address->line3 = $request->get('sline3');
			$merchant_address->line4 = $request->get('sline4');
			$merchant_address->type = 'default';

			return $merchant_address->save();
		}
    }	
}
