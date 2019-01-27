<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EMail extends Model
{
	protected $table = 'emails';
	protected $fillable= ['user_id','type','do_id','status','retrytimes'];
	
    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
    
    public function deliveryorder()
    {
    	return $this->belongsTo('App\Models\DeliveryOrder','do_id','id');
    }
}
