<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model {
protected $table = "feedback";
protected $guarded = ['deleted_at'];
protected $fillable = ['name', 'phone', 'remarks', 'address', 'email', 'company_name', 'company_phone', 'company_email', 'company_address'];
}
