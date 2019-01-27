<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model {
	protected $table = "job";
	protected $guarded = ['deleted_at'];
	protected $fillable = ['name', 'phone', 'remarks', 'email', 'position_applied'];
        
}