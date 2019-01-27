<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    protected $table = 'payment';

    //---Order Method---//
    public function order(){
        return $this->hasOne('App\Models\POrder');
    }
    
    public function getCurrentCountrySalesRevenueDetails($id,$fromDate,$toDate)
    {
		return $this->join('porder','porder.payment_id','=', 'payment.id')
		->join('users', 'porder.user_id', '=', 'users.id')
		->join('country','country.id', '=', 'users.nationality_country_id')  
		->selectRaw('SUM(payment.receivable) AS total_payment,payment.consignment')
		->where('users.nationality_country_id',$id)
		->where('payment.consignment', '>', $fromDate)
		->where('payment.consignment', '<', $toDate)
		->groupBy(
			DB::raw('YEAR(payment.consignment)'),
			DB::raw('MONTH(payment.consignment)'))
		->orderBy('payment.consignment')->get();
    }
    
    public function getCurrentCountryNumberOfPayments($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('country', 'country.id', '=', 'users.nationality_country_id')  
             ->selectRaw('count(*) AS total')
             ->where('users.nationality_country_id',$id)
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->orderBy('payment.consignment')->get();
    }
    
    public function getCurrentStateSalesRevenueDetails($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('merchant', 'merchant.user_id', '=', 'users.id')
             ->join('address', 'merchant.address_id', '=', 'address.id')
             ->join('city', 'city.id', '=', 'address.city_id')
             ->join('state', 'state.code', '=', 'city.state_code')
             ->selectRaw('SUM(payment.receivable) AS total_payment,payment.consignment')
             ->where('state.id',$id)
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->groupBy(
			 	DB::raw('YEAR(payment.consignment)'),
				DB::raw('MONTH(payment.consignment)'))
             ->orderBy('payment.consignment')->get();
    }
    
    public function getCurrentStateNumberOfPayments($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('merchant', 'merchant.user_id', '=', 'users.id')
             ->join('address', 'merchant.address_id', '=', 'address.id')
             ->join('city', 'city.id', '=', 'address.city_id')
             ->join('state', 'state.code', '=', 'city.state_code')
             ->selectRaw('count(*) AS total')
             ->where('state.id',$id)
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->orderBy('payment.consignment')->get();
    }
    
    public function getCurrentMerchantSalesRevenueDetails($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('merchant', 'users.id', '=', 'merchant.user_id')  
             ->selectRaw('SUM(payment.receivable) AS total_payment,payment.consignment')
             ->where('merchant.id',$id)
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->groupBy( DB::raw('YEAR(payment.consignment)'), DB::raw('MONTH(payment.consignment)'))
             ->orderBy('payment.consignment')->get();
    }
    
    public function getCurrentMerchantNumberOfPayments($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('merchant', 'users.id', '=', 'merchant.user_id')  
             ->selectRaw('count(*) AS total')
             ->where('merchant.id',$id)
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->orderBy('payment.consignment')->get();
    }
    
    public function getCurrentMerchantConsultantSalesRevenueDetails($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('sales_staff', 'users.id', '=', 'sales_staff.user_id')  
             ->selectRaw('SUM(payment.receivable) AS total_payment,payment.consignment')
             ->where('sales_staff.id',$id)
             ->where('sales_staff.type','mct')
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->groupBy(DB::raw('YEAR(payment.consignment)'), DB::raw('MONTH(payment.consignment)'))
             ->orderBy('payment.consignment')->get();
    }
    
    public function getCurrentMerchantConsultantNumberOfPayments($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('sales_staff', 'users.id', '=', 'sales_staff.user_id')  
             ->selectRaw('count(*) AS total')
             ->where('sales_staff.id',$id)
             ->where('sales_staff.type','mct')
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->orderBy('payment.consignment')->get();
    }
    
    public function getWorldSalesRevenueDetails($fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->selectRaw('SUM(payment.receivable) AS total_payment,payment.consignment')
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->groupBy(DB::raw('YEAR(payment.consignment)'), DB::raw('MONTH(payment.consignment)'))
             ->orderBy('payment.consignment')->get();
    }
    
    public function getWorldNumberOfPayments($fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->selectRaw('count(*) AS total')
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->orderBy('payment.consignment')->get();
    }

    public function getCurrentStationSalesRevenueDetails($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('station', 'users.id', '=', 'station.user_id')  
             ->selectRaw('SUM(payment.receivable) AS total_payment,payment.consignment')
             ->where('station.id',$id)
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->groupBy( DB::raw('YEAR(payment.consignment)'), DB::raw('MONTH(payment.consignment)'))
             ->orderBy('payment.consignment')->get();
    }

    public function getCurrentStationNumberOfPayments($id, $fromDate, $toDate)
    {
        return $this->join('porder','porder.payment_id','=', 'payment.id')
             ->join('users', 'porder.user_id', '=', 'users.id')
             ->join('station', 'users.id', '=', 'station.user_id')  
             ->selectRaw('count(*) AS total')
             ->where('station.id',$id)
             ->where('payment.consignment', '>', $fromDate)
             ->where('payment.consignment', '<', $toDate)
             ->orderBy('payment.consignment')->get();
    }        
}
