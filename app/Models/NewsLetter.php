<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model {
	protected $table = "newsletter";
	protected $guarded = ['deleted_at'];
	protected $hidden = ['password', 'remember_token'];
}