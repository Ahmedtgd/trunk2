<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HcapSchedule extends Model
{
    protected $table    = 'hcap_schedule';

    protected $fillable = ['staff_user_id','scheduled_day','shift_id','leavetype_id'];

    public function shift()
    {
        return $this->belongsTo(HcapShift::class);
    }
    public function leaveType()
    {
        return $this->belongsTo(HcapLeaveType::class,'leavetype_id');
    }
}
