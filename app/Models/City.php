<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $guarded = ['id'];

    /*city has only one address 1:1*/
    public function address()
    {
        return $this->hasOne('App\Models\Address','city_id','id');
    }
	
    public function getCitiesOfCurrentState($code)
    {
        return $this->where('state_code', $code)->lists('name','id')->all();
    }	

}
