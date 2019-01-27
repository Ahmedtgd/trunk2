<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wholesale extends Model
{
    protected  $table = 'wholesale';

    public function storewholesale($request,$product_data)
    {
        for ($i = 0; $i < (($request->wholesaleprices)+1); $i++) {
            $wholwsale_table = new wholesale();
            $wholwsale_table->product_id = $product_data->id;
            $wholwsale_table->unit = $request->wholesaleunits[$i];
            $wholwsale_table->funit = $request->wholesalefunits[$i];
            $wholwsale_table->price = $request->wholesalepricesa[$i]*100;
			if($request->wholesalepricesa[$i]>0){
				$wholwsale_table->save();
			}
        }
    }

    public function autolink()
    {
        return $this->belongsTo('App\Models\Autolink','autolink_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
