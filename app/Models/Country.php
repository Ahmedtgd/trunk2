<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = "country";
    protected $guarded = [ 'id'];

    public static function getCountryName($country_code)
    {
        $country = Country::where('code','=',$country_code)->first();
        return $country['name'];
    }

    /*Country has only one station 1:1*/
    public function station()
    {
        return $this->hasOne('App\Models\Station','country_id','id');
    }

    /*Country has only one station 1:1*/
    public function state()
    {
        return $this->hasOne('App\Models\State','country_code','code');
    }

    public function getCountryCode($id)
        {
            return $this->where('id',$id)->first();
        }
}
