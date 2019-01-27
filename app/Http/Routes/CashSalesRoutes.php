<?php

Route::post('merchant/cashtoday', 'CashSalesController@cash_today');
Route::get('merchant/cashsalesYtd','CashSalesController@cash_Sales_Ytd');
Route::get('merchant/cashsalesMtd','CashSalesController@cash_Sales_Mtd');
Route::get('merchant/cashsalesWtd','CashSalesController@cash_Sales_Wtd');
Route::get('merchant/cashsalesToday','CashSalesController@cash_Sales_Today');
Route::get('merchant/cashsale', 'CashSalesController@cash_Sales_default');
Route::get('merchant/cashsales', 'CashSalesController@cashsales');