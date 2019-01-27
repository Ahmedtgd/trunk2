<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoryadimage extends Model
{
    protected $table = 'categoryadimage';

    public function category()
    {
    	return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function image()
    {
    	return $this->belongsTo('App\Models\AdImage','adimage_id','id');
    }
}
