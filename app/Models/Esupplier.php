<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Esupplier extends Model
{
    protected $table = 'esupplier';
	protected $fillable = ['company_name', 'business_reg_no',
		'address_id', 'first_name', 'last_name', 'designation', 'mobile_no',
		'email', 'registered'];
}
