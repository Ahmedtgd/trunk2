<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refrigerator extends Model {

	protected $table = 'fstorage';
//	protected $fillable = ["area", 'reason_text'];

	public function product() {
		return $this->hasMany('App\Models\Product', 'id', 'product_id');
	}
      

}
