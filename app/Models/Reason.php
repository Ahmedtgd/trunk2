<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model {

	protected $table = 'crereasons';
	protected $fillable = ["area", 'reason_text'];

	public function cre() {
		return $this->hasMany('App\Models\Cre', 'crereason_id', 'id');
	}

}
