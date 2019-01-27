<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesStaff extends Model
{
    //
    protected $table ='sales_staff';
    protected $fillable = ["user_id"];

    public function users(){
        return $this->belongsTo("App\Models\User",'user_id', 'id');
    }
    /*salestaff has only one merchant 1:1*/
    public function Mastermerchant()
    {
        return $this->hasOne('App\Models\MasterMerchant','mc_sales_staff_id','id');
    }
    /*salestaff has only one mc_id_referal 1:1*/
    public function mc_id_referal()
    {
        return $this->hasOne('App\Models\MasterMerchant','referral_sales_staff_id', 'id');
    }
    /*salestaff has only one mcp1_id 1:1*/
    public function mcp1_id()
    {
        return $this->hasOne('App\Models\MasterMerchant','mcp1_sales_staff_id', 'id');
    }
    /*salestaff has only one mcp2_id 1:1*/
    public function mcp2_id()
    {
        return $this->hasOne('App\Models\MasterMerchant','mcp2_sales_staff_id', 'id');
    }

    public function getAllMerchantConsultants()
    {
        return $this->join('users', 'sales_staff.user_id', '=', 'users.id')->orderBy('users.name')->lists('users.name','sales_staff.id')->all();
    }
}
