<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StationAddress extends Model
{
    protected $table = 'stationaddress';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['station_id', 'address_id'];

    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id', 'station_id');
    }
}
