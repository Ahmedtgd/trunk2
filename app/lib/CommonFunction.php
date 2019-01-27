<?php

namespace App\lib;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class CommonFunction {

    public function getCurrency() {
        $list = DB::table('currency')->lists('code', 'id');
        return $list;
    }

    public function getLanguage() {
        $list = DB::table('language')->lists('description', 'id');
        return $list;
    }

    public function getCountry() {
        $list = DB::table('country')->lists('name', 'id');
        return $list;
    }

    public function getCity() {
        $list = DB::table('city')->lists('name', 'id');
        return $list;
    }
	
    public function getCityByState($state_code) {
        $list = DB::table('city')->where('state_code',$state_code)->lists('name', 'id');
        return $list;
    }	

    public function getArea() {
        $list = DB::table('area')->lists('name', 'id');
        return $list;
    }
	
	 public function getMerchant() {
        $list = DB::table('merchant')->where('status','active')->lists('company_name', 'id');
        return $list;
    }
	
	public function getProduct($merchant_id) {
        $list = DB::table('product')->join('merchantproduct','product.id','=','merchantproduct.product_id')
		->where('product.status','active')->where('merchantproduct.merchant_id',$merchant_id)->lists('product.name', 'product.id');
        return $list;
    }
	
    public function getAreaByCity($city_id) {
        $list = DB::table('area')->where('city_id',$city_id)->lists('name', 'id');
        return $list;
    }	

    public function getBank() {
        $list = DB::table('bank')->lists('name', 'id');
        return $list;
    }

    public function getState() {
        $list = DB::table('state')->where('country_code','MYS')->lists('name', 'id');
        return $list;
    }

    public function getStateM() {
        $list = DB::table('state')->where('country_code', 'MYS')->lists('name', 'id');
        return $list;
    }

    public function getOccupation() {
        $list = DB::table('occupation')->lists('name', 'id');
        return $list;
    }

    public function getOutlet() {
        $list = DB::table('outlet')->lists('description', 'id');
        return $list;
    }

    public function getDelivery() {
        $list = array('Pickup & Delivery','Pickup','Pickup & Self Delivery');
        return $list;
    }

    public function getBusinessType() {
        $list = Config::get('enumDropDowns.merchant.business_type'); //DB::table('merchant')->pluck('business_type');//lists('business_type','business_type');
        //  dd($selectListForBusinessType);
        return $list;
    }

    public function getAddressType() {
        $list = Config::get('enumDropDowns.address.type'); //DB::table('merchant')->pluck('business_type');//lists('business_type','business_type');
        //  dd($selectListForBusinessType);
        return $list;
    }

    public function category() {
        $list = DB::table('category')->lists('description', 'id');
        return $list;
    }

    function set_active($uri) {
        return Request::is($uri) ? 'active' : '';
    }
	
    function set_activeseller($uri) {
        return Request::is($uri) ? 'activeseller' : '';
    }	

}
