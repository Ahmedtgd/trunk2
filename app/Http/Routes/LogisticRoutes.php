<?php
Route::get('lp/dashboard','LogisticsController@showDashboard');
Route::get('lp/employees/{id}/{user_id}',['as' => 'employeeLogistic', 'uses'=>'LogisticsController@logisticEmployee']);
Route::post('/lp/add_employee',['as' => 'addemployeelp', 'uses'=>'LogisticsController@add_employee']);
Route::post('/lp/member/delete',['as' => 'deletememberlp', 'uses'=>'LogisticsController@deletemember']);
Route::post('/lp/send_emails',['as' => 'sendemailslp', 'uses'=>'LogisticsController@send_emails']);
Route::post('lp/pricing/add','LogisticsController@newPricing');
Route::get('lp/pricing/check','LogisticsController@checkPricing');
Route::get('lp/dos/{logistic_id}/{type}','LogisticsController@showDos');
Route::post('lp/pricing/lock','LogisticsController@lockPricing');
Route::post('lp/pricing/unlock','LogisticsController@unlockPricing');
Route::post('lp/pricing/update','LogisticsController@updatePricing');
Route::post('lp/approveMember','LogisticsController@approveMember');
Route::post('lp/pricing/delete','LogisticsController@deletePricing');
Route::post('lp/saveMemberRemarks','LogisticsController@saveMemberRemarks');

// Get Address

Route::get('lp/address/{cn}/{type}','LogisticsController@initAddressModal');
Route::get('lp/addresses/{cn}/{type}','LogisticsController@initAddressesModal');
Route::get('lp/start/{cn}','LogisticsController@startOrder');


// For Logistic Provider [shared by admin]

Route::group(['prefix'=>'lp'],function(){
	Route::get('pricing/{logistic_id}','LogisticsController@showPricing')
	->name('lppricing');
	Route::get('collect/package/{cn}','LogisticsController@collectPackage');
	Route::get('capability/{logistic_id}','LogisticsController@showCapability');
	Route::post('lgrade','LogisticsController@changeGrade');
	// Route::get('')
});

// Logistic Statement Route

Route::get('l/{month}/{year}/{logistic_id?}','StatementController@showLogisticStatement');
Route::get('pdf/l/{month}/{year}/{logistic_id?}','StatementController@downloadLogisticStatement');
// Commong for buyer and merchant

Route::get('call/logistic/{oid}/{type?}','LogisticsController@initCLModal');
Route::get('label/download/{oid}/{type?}','LogisticsController@downloadLabel');
Route::get('init/logistic/modal','CityLinkController@initModal');
Route::post('call/logistic','LogisticsController@callLogistic');

// For App
/*
Returns
*/ 
Route::post('delivery/details','LogisticsController@getDeliveryDetails');

Route::get('is/logistic','LogisticsController@is_logistic');

/*NINJAVAN WEBHOOKS*/
Route::post("nv/sdelivery","NinjaVanController@handle_sdelivery"); 

?>
