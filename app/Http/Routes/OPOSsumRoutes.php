<?php

Route::get('/opossum', 'OpossumController@index')->name('opposum.trunk.index');

Route::get("/opossum/on-load-update-data",'OpossumController@getOnLoadUpdateData');
Route::post("/opossum/save-service-charges",'OpossumController@saveServiceCharges');
Route::get("/opossum/close-lockerkey",'OpossumController@closeLockerKey');
Route::get("/opossum/reset-lockerkey",'OpossumController@resetLockerkey');


Route::get("/apply-selected-service-charge",'OpossumController@applySelectedServiceCharge');


Route::get('/listproduct/{terminal_id}', 'OpossumController@listproduct')->name('listproduct');
Route::get('/skulist/{terminal_id}/{uid?}', 'OpossumController@skulist')->name('skulist');
Route::POST('/savelocalprice','OpossumController@saveLocalPrice');

Route::post('/savesparoom', 'OpossumController@savesparoom')->name('savesparoom');
Route::get('/sparooms/{terminal_id}', 'OpossumController@sparooms')->name('sparooms');
Route::get('/lockerkeys/{terminal_id}', 'OpossumController@lockerkeys')->name('lockerkeys');
Route::get('/check_existance/{type}/{fnum}/{terminal_id}', 'OpossumController@check_existance')->name('check_existance');
Route::post('/checkin', 'OpossumController@checkin')->name('checkin');
Route::post('/checkoutsparoom', 'OpossumController@checkoutsparoom')->name('checkoutsparoom');
Route::get('/deleteroom/{id}', 'OpossumController@deleteroom')->name('deleteroom');
Route::post('/saverec', 'OpossumController@saverec')->name('saverec');
Route::post('/savediscountbtn', 'OpossumController@savediscountbtn')->name('savediscountbtn');
Route::get('/getdiscountbtn', 'OpossumController@getdiscountbtn')->name('getdiscountbtn');

// Route::get('/opossum-operation-hrs-variables/{uid?}', 'OpossumController@operation_hours_variables');
Route::get('/get-member-location-data/{uid?}
	', 'OpossumController@getMemberLocationData');



Route::get('/stockout/{location_id}/{uid?}', 'OpossumController@stockout')->name('stockout');

/*Table Routes . Please give unique names to routes Also Please start the route with opossum prefix*/
Route::get('/table/{terminal_id}', 'OpossumController@table')->name('table');
//Route::any('/table/{table}/{fnum}', 'OpossumController@table')->name('table'); //not unique name
Route::post('/savetable', 'OpossumController@savetable')->name('savetable');
Route::post('/savehotelroom', 'OpossumController@savehotelroom')->name('savehotelroom');
Route::post('/lokerkeydata', 'OpossumController@lokerkeydata')->name('lokerkeydata');
Route::post('/setbfunction', 'OpossumController@setbfunction')->name('setbfunction');

Route::get('/hotelroom', 'OpossumController@hotelroom')->name('hotelroom');
Route::get('/getbfunction', 'OpossumController@getbfunction')->name('getbfunction');
/**/
Route::group(array("prefix"=>"opossum"),function(){
	Route::post("transaction/{action}/{uid?}","OpossumController@transaction");
	Route::post("product/{action}/{uid?}","OpossumController@product");
	Route::get("receipt/{action}/{receipt_id}/{uid?}","OpossumController@receipt");
	Route::get("support/{type}/{user_id?}","OpossumController@support");
	Route::post('/stockin/{uid?}', 'OpossumController@stockin')->name('stockin');
	Route::post('/deletelokersession', 'OpossumController@deletelokersession');
	Route::post("servicecharge/active/{uid?}","OpossumController@servicecharge_active");
	Route::post("eod","OpossumController@eod");
	Route::post("otherpoint","OpossumController@otherpoint");
	Route::post("otherpoint/save",'OtherPointController@add');
	/*ProductPreferenceRoutes*/
	Route::group(array("prefix"=>"pp"),function(){
		Route::get('products/{terminal_id}','OpossumProductPreferenceController@all_products');
		Route::post('update_product','OpossumProductPreferenceController@update_product');
		Route::post('showreceiptaddress','OpossumProductPreferenceController@showreceiptaddress');
		Route::post('savereceiptaddress','OpossumProductPreferenceController@savereceiptaddress');
		Route::post('showreceiptlogo','OpossumProductPreferenceController@showreceiptlogo');
		Route::post('savereceiptlogo','OpossumProductPreferenceController@savereceiptlogo');

	});
	Route::group(["prefix"=>"member"],function(){
		Route::get("view/{terminal_id}","OpossumMemberController@view");
		Route::post("customer/create",'OpossumMemberController@create_customer');
		Route::post("staff/create",'OpossumMemberController@create_staff');
	});

});

//********************** Document *************************
Route::post('/opos_tax_invoice/document', 'OpossumController@list_terminal');
Route::get('/showreceipt/{from}/{to}/{terminalid}', 'OpossumController@showreceipt');
Route::get('/showreceiptproduct/{id}/{user_id?}', 'OpossumController@showreceiptproduct');
// Route::get('/statement/showreceiptlist/{terminal_id}', 'OpossumController@showreceiptlist');
Route::get('/showopossumreceipt/{id}', 'OpossumController@showopossumreceipt');
Route::get('/digitalclock', 'OpossumController@digitalclock');


Route::post('/opossum/savelokersession', 'OpossumController@savelokersession');
Route::get('/opossum/showSavedData', 'OpossumController@showSavedData');

Route::post('/opossum/getftypeid', 'OpossumController@getftypeid');
Route::post('/serveicecherge', 'OpossumController@serveicecherge');

Route::get('/opossum/{terminal_id}/{uid?}', 'OpossumController@index')->name('opposum.trunk.index');
Route::group(['middleware' => 'admin'],function(){
Route::get('/opossum/{terminal_id}/{merchant_id}', 'OpossumController@index')->name('opposum.trunk.index');
});
Route::get("/opossumLogin/verification",'OpossumController@getMobileVerification');
Route::get('/opossumLogin/{uid?}', 'OpossumController@opossumLogin');
Route::post('/OpopssumLoginUser/{uid?}', 'OpossumController@OpopssumLoginUser');
Route::post('/validateOpossumLoginData/{uid?}', 'OpossumController@validateOpossumLoginData');
Route::get('/getCompanyData/{user_id}', 'OpossumController@getCompanyData');
Route::post("/companylocation/{uid?}","OpossumController@companylocation");


Route::post("/locationterminal/{uid?}","OpossumController@locationterminal");
Route::get("/opossum/function/{uid?}",'OpossumController@getStaffMode');

Route::post("/checkData/{uid?}","OpossumController@checkData");
Route::post("/varifyvoucher/{uid?}","OpossumController@varifyvoucher");
Route::post("/redeemvoucher/{uid?}","OpossumController@redeemvoucher");

/*PlatyPOS -Opossum Routes*/
Route::group(["prefix"=>"platypos"],function(){
	Route::post("transaction/linkedproducts/{uid?}","rn\PlatyPOSController@linkedproducts");
	Route::post("transaction/end/{uid?}","rn\PlatyPOSController@end_transaction");
});


Route::post("/branchsales",'OpossumReceiptController@getBranchSales');

Route::post("/refund/getrefunds",'OpossumReceiptController@getRefunds');
Route::post("/refund/confirmrefund",'OpossumReceiptController@confirmRefund');
Route::post("/refund/saverefunds",'OpossumReceiptController@saveRefunds');


/*EOD SUMMARY*/

Route::get('eod/summary/{id}/{id_type?}','OposEodController@last_eod_summary');
Route::get('/statement/showreceiptlist/{terminal_id}', 'OposEodController@showreceiptlist');
Route::get('/opossum-operation-hrs-variables/{uid?}', 'OposEodController@operation_hours_variables');

Route::get('showrefund','OpossumReceiptController@showRefund');