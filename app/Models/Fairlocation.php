<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fairlocation extends Model
{
    protected $table='fairlocation';
    
    protected $fillable =['code','default_initial_location'];
    public function stock()
    {
        return $this->hasOne('App\Models\Stockreport','fairlocation_id','id');
    }
}
