<?php
	
Route::get('seller/deliveryorder/{user_id?}','DoManagementController@index')->name('deliveryorder');
Route::get('seller/complete_do/{id}','DoManagementController@complete_do');
Route::post('deliveryorder/document','StatementController@doissued');
Route::post('deliveryorderreceived/document','StatementController@doreceived');
Route::post('seller/issue/do','DoManagementController@issueDo')->name('issue.do');
Route::post('seller/tr/do','DoManagementController@trDo')->name('tr.do');
Route::post('seller/discard/do','DoManagementController@discardDo')->name('discard.do');
Route::post('seller/import/file','DoManagementController@importDo')->name('import.do');
Route::post('seller/export/file','DoManagementController@exportDo')->name('export.do');
Route::get('seller/canceltr/{id}','DoManagementController@canceltr')->name('canceltr');
Route::get('importedstatus/{id}','DoManagementController@importedstatus')->name('importedstatus');
Route::get('seller/directinvoice/{porder_id?}','DoManagementController@OrderDelivery');
Route::get('seller/Sofooterdetails/{porder_id}','DoManagementController@soFooterdetails');
Route::get('/DO/displaydeliveryorderpopup/{id}','GatorController@displaydeliveryorderpopup');
?>