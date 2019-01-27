<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HcapLeaveType extends Model
{
    protected $table    = 'hcap_leavetype';

    protected $fillable = ['name','description'];

    public function schedules()
    {
        return $this->hasMany(HcapSchedule::class);
    }
}
