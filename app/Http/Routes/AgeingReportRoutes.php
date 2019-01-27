<?php
Route::get('/seller/debtorageingdirect/{uid?}/{station_id?}',
	'AgeingReportController@debtorageingdirect');

Route::get('/seller/creditorageing/{uid?}/{station_id?}',
	'AgeingReportController@creditageinreport');

Route::get('/seller/creditorageingall/{uid?}/{station_id?}', [
	'as' => 'sellerdageing',
	'uses'=>'SellerHelpController@cageinreport'
]);

Route::get('/seller/ntproduct-id/{merchant_id?}/{merchant_uid?}', [
	'as' => 'ntproduct-id',
	'uses'=>'AgeingReportController@get_ntproductid'
]);

Route::get('/seller/creditor_balance/{id}/{user_id}/{sellid?}', [
	'as' => 'sellerdageingbalance',
	'uses'=>'SellerHelpController@creditor_balance'
]);

Route::get('/seller/debtorageing/{uid?}/{station_id?}', ['as' => 'sellercageing', 'uses'=>'AgeingReportController@debtorageingdirect']);

Route::post('/seller/save_credit_notes/{uid?}/{station_id?}','AgeingReportController@saveCreditNote');
?>
