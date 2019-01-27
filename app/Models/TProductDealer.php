<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TProductDealer extends Model
{
    protected $table = 'tproductdealer';

    public function storetproductDealer($request,$product_data)
    {
        for ($i = 0; $i < (($request->wholesaleprices)+1); $i++) {
            $productdealer_table = new tproductdealer();
            $productdealer_table->tproduct_id = $product_data;
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
