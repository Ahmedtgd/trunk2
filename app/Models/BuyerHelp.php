<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerHelp extends Model {
	protected $table = 'buyer_help';
	protected $fillable = ['name', 'phone','remarks', 'email'];
}