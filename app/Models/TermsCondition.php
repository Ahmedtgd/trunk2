<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model {
	protected $table = "terms_conditions";
	protected $guarded = ['deleted_at'];
        protected $fillable = ['ip_address', 'agree'];
}