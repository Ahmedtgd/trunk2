<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadApp extends Model {
	protected $table = "download_apps";
	protected $guarded = ['deleted_at'];
	protected $hidden = ['password', 'remember_token'];
}