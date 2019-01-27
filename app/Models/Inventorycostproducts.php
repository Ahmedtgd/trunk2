<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Inventorycostproducts extends Model
{
    protected $table = 'inventorycostproduct';
    public $timestamps = true;
	protected $fillable = ['inventorycost_id', 'product_id', 'quantity', 'cost'];

	public function inventorycost()
    {
        return $this->belongsto(Inventorycost::class);
    }
}
