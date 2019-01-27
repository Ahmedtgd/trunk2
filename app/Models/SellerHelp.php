<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerHelp extends Model {
	protected $table = 'seller_help';
	protected $fillable = ['name', 'phone','remarks', 'email','company_name','business_reg_no'];
}