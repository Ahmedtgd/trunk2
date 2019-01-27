<?php

Route::get('/open-sales/user/{user_id}','SalesController@viewSales');
Route::get('/open-sales/{id}','SalesController@viewRawMaterial');

Route::post('/sales_log','SalesLogController@viewSalesLog');
Route::post('/sales_log/savedata','SalesController@saveSalesLog');
Route::post('/sales_log/savelockerproduct','SalesController@savelockerproduct');
Route::post('/sales_log/startmasseurData','SalesController@startMasseurData');
Route::post('/sales_log/endmasseurData','SalesController@endMasseurData');
Route::post('/sales_log/checkproducts','SalesController@checkproducts');
Route::post('/sales_log/getupdatedproducts','SalesController@getUpdatedProducts');

/*SalesLog Route*/
Route::group(['prefix'=>'saleslog'],function(){
	Route::post('update','SalesLogController@update_saleslog');
	Route::post('fetch/keys','SalesLogController@fetch_lockerkeys');
	Route::post('fetch/rooms','SalesLogController@fetch_sparooms');
	Route::post('fetch/masseurs','SalesLogController@fetch_masseurs');
	Route::get('active/months/{year?}','SalesLogController@active_months');
	Route::post('active/days','SalesLogController@active_days');
	Route::post("view/saleslog/all",'SalesLogController@view_saleslog_all');
	Route::get("view/{terminal_id}/{year}/{month}",'SalesLogController@view_saleslog_all');
	Route::get("range/view/{logterminal_id}",'SalesLogController@view_saleslog_by_range');;
});
