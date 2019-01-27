<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;


class Outlet extends Model
{
    protected $table = 'outlet';

    public function outlet()
    {
        return $this->hasOne('App\Models\Sproperty','outlet_id','id');
    }

    public static function getOutletName()
    {
        $outlet = Outlet::all();
        return $outlet['name'];
    }

}
