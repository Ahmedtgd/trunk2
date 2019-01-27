<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tproduct extends Model
{
    protected $table = 'tproduct';
    protected $appends = ['productaverage'];

    public function inventorycostproducts()
    {
        return $this->hasMany(Inventorycostproducts::class, 'product_id', 'product_id');
    }

    function getProductaverageAttribute() {
    	// product average is total price/total quantity bought
    	// calculate total price    	
    	$totalPrice = 0;
    	$totalQnty = 0;
    	$average = 0;
    	if($this->inventorycostproducts->count()>0){
    		foreach($this->inventorycostproducts as $inventorycostproduct) {
    			$totalPrice += ($inventorycostproduct->cost * $inventorycostproduct->quantity);
    			$totalQnty += $inventorycostproduct->quantity;
    		}
    		//calculate average
    		$average = $totalPrice/$totalQnty;
    		
    		//convert averag to currency
    		$average = $average/100;
    	}
  		return $average;
	}
}
