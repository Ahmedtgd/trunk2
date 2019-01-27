<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Inventorycost extends Model
{
    protected $table = 'inventorycost';
    public $timestamps = true;
    // protected $appends = ['average'];
	protected $fillable = ['esupplier_id', 'doc_date', 'doc_no'];

	// function getAverage() {
 //  		return 10;
	// }
	public function inventoryproducts()
    {
        return $this->hasMany(Inventorycostproducts::class);
    }
}
