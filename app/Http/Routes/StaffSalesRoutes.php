<?php
Route::get('merchant/staffsales', "SalesStaffController@staffsales");
Route::get('merchant/staffsale', "SalesStaffController@staffsale");
Route::get('merchant/staffsaleYtd', "SalesStaffController@staffsaleYtd");
Route::get('merchant/staffsaleMtd', "SalesStaffController@staffsaleMtd");
Route::get('merchant/staffsaleWtd', "SalesStaffController@staffsaleWtd");
Route::post('merchant/staffsaletoday', "SalesStaffController@staffsaletoday");
