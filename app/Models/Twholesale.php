<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Twholesale extends Model
{
    protected  $table = 'twholesale';

    public function storetwholesale($request,$tproduct_id)
    {
        for ($i = 0; $i <(($request->wholesaleprices)); $i++) {
            $wholesale_table = new twholesale();
            $wholesale_table->tproduct_id = $tproduct_id;
            $wholesale_table->unit = $request->wholesaleunits[$i];
            $wholesale_table->funit = $request->wholesalefunits[$i];
            $wholesale_table->price = $request->wholesalepricesa[$i]*100;
			$wholesale_table->save();
        }
    }
}
