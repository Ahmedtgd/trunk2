<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StationProduct extends Model
{
    protected $table = 'stationsproduct';

	public function stations() {
		return $this->hasMany('App\Models\Station', 'station_id');
	}

	public function products() {
		return $this->hasMany('App\Models\Product', 'sproduct_id');
	}

	public function storeproduct($product_data,$station_id)
	{
		$records =[
			'merchant_id' 	=> $merchant_id,
			'product_id'	=> $product_data->id,
		];
		$station_pro = new StationProduct();
		return $station_pro->create($records);
	}
}
