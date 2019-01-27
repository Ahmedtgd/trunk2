<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model {

	protected $table = "privacy_policy";
	protected $guarded = ['deleted_at'];
        protected $fillable = ['ip_address', 'agree'];
}