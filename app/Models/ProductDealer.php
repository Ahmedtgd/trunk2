<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDealer extends Model
{
    protected $table = 'productdealer';

    public function Dealers()
    {
        return $this->hasMany('App\Models\Dealer');
    }

    public function storeproductDealer($request,$product_data)
    {
        for ($i = 0; $i < (($request->wholesaleprices)+1); $i++) {
            $productdealer_table = new productdealer();
            $productdealer_table->product_id = $product_data->id;
			$productdealer_table->special_unit = $request->wholesaleunits[$i];
            $productdealer_table->special_funit = $request->wholesalefunits[$i];
            $productdealer_table->dealer_id = $request->did;
            $productdealer_table->special_price = $request->wholesalepricesa[$i]*100;
			if($request->wholesalepricesa[$i]>0){
				$productdealer_table->save();
			}
        }
    }
}
