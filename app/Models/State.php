<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';


    public function station()
    {
        return $this->hasOne('App\Models\Station','state_id','id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country','country_code','code');
    }

    public function getStateCode($id)
    {
        return $this->where('id',$id)->first();
    }
	
    public static function getStateName($state_code)
    {
        $state = State::where('code',$state_code)->first();
        return $state['name'];
    }	

    public function getStatesOfCurrentCountry($code)
    {
        return $this->where('country_code', $code)->lists('name','id')->all();
    }
}
