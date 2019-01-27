<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stockreport extends Model
{
    protected $table='stockreport';

    public function checker()
    {
        return $this->belongsTo('App\Models\User','checker_user_id','id');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User','creator_user_id','id');
    }

    public function checker_company()
    {
        return $this->belongsTo('App\Models\Company','checker_company_id','id');
    }

    public function creator_company()
    {
        return $this->belongsTo('App\Models\Company','creator_company_id','id');
    }

    public function fairlocation()
    {
        return $this->belongsTo('App\Models\Fairlocation','fairlocation_id','id');
    }

    public function checker_location()
    {
        return $this->belongsTo('App\Models\Fairlocation','checker_location_id','id');
    }
    public function creator_location()
    {
        return $this->belongsTo('App\Models\Fairlocation','creator_location_id','id');
    }

    public function report_products()
    {
        return $this->hasMany('App\Models\Stockreportproduct','stockreport_id','id');
    }
}
//$stockreport=new \App\Models\Stockreport(); 
//$stock=$stockreport
//->select("stockreport.id as stockreport_id",DB::RAW("count(*) as total")
//      ,DB::RAW("EXTRACT(YEAR_MONTH FROM stockreport.created_at) as month")) 
////        ->with(["creator","checker", // "checker_company","creator_company", // "fairlocation","checker_location", // "creator_location","report_products"])
//         ->whereBetween("created_at", [date("Y-01-01") ,date("Y-12-31")]) 
//        ->groupBy(DB::RAW("EXTRACT(YEAR_MONTH FROM stockreport.created_at)")) 
//        ->get();