<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCatLevel1 extends Model
{
     protected $table='subcat_level_1';

     public function category()
	{
		return $this->belongsTo('App\Models\Category','category_id');
	}
  public function product()
    {
        return $this->hasMany('App\Models\Product','subcat_id');
    }
	
    public function getSubsOfCurrentCat($id)
    {
        return $this->where('category_id', $id)->lists('description','id')->all();
    }		
    	
}
