<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 12/3/2018
 * Time: 16:25
 */


Route::get('/merchant/credit-staff-sales/data','CreditStaffSalesController@creditStaffSalesData');
Route::get('/merchant/credit-staff-sales/{uid?}','CreditStaffSalesController@creditStaffSales');