<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;


class Area extends Model
{
    protected $table = 'area';
    protected $guarded = ['id'];

    /*starts relations*/

    /*area has only one address 1:1*/
    public function address()
    {
        return $this->hasOne('App\Models\Address','area_id','id');
    }
	
    public function getAreasOfCurrentCity($id)
    {
        return $this->where('city_id', $id)->lists('name','id')->all();
    }		

}
