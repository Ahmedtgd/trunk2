<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpSeller extends Model {
	protected $table = 'seller_help';
	protected $fillable = ['name', 'phone', 'order_id', 'email', 'remarks', 'company_name', 'business_reg_no'];
}