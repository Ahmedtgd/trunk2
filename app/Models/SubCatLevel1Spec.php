<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCatLevel1Spec extends Model
{
    protected $table = 'subcat_level_1spec';
	
      public function subCatLevel1()
	{
		return $this->belongsTo('App\Models\SubCatLevel1','subcat_level_1_id');
	}
	
	public function specification()
	{
		return $this->belongsTo('App\Models\Specification','spec_id');
	}
}
