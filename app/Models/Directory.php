<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model {
	protected $table = 'directory';
	protected $fillable = ['company', 'business_reg_no', 'name', 'phone',
		'address', 'email', 'occupation_id'];
}