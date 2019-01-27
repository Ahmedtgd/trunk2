<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HcapShift extends Model
{
    protected $table    = 'hcap_shift';

    protected $fillable = ['name','description','start','end'];

    public function schedule()
    {
        return $this->hasOne(HcapSchedule::class);
    }
}
