<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpBuyer extends Model {
	protected $table = 'buyer_help';
	protected $fillable = ['name', 'phone', 'porder_id', 'email', 'remarks'];
}
