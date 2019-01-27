<?php
/* Inventorycost Custom Routes */
Route::group(['middleware'=>'merchant'],function(){
	//Route::get('/inventorycost','InventoryCostController@index');
	Route::post('/inventorycost','InventoryCostController@index');
	Route::post('/inventorycost/save_inventory_cost', ['as' => 'saveinventorycost', 'uses'=>'InventoryCostController@saveInventorycost']);
	Route::get('/inventorycost/add_product', ['as' => 'add_product', 'uses'=>'InventoryCostController@inventorycostAddProduct']);
	Route::get('/inventorycost/new_supplier', ['as' => 'new_supplier', 'uses'=>'InventoryCostController@inventorycostNewSupplier']);
	Route::get('/inventorycost/registered_supplier', ['as' => 'registered_supplier', 'uses'=>'InventoryCostController@inventorycostRegisterdSupplier']);
	Route::get('/inventorycost/average', ['as' => 'average', 'uses'=>'InventoryCostController@inventorycostAverage']);
	Route::get('/inventorycost/details', ['as' => 'details', 'uses'=>'InventoryCostController@inventorycostDetails']);
});
/******************************New Routes**************************************/
Route::get('/inventorycost/{user_id?}','EinventoryController@index')->name('einventory');
Route::get('/seller/einventorybuyer/modal/{user_id?}','EinventoryController@einventoryBuyer');
Route::get('/seller/einventory/saleorder/{id}','EinventoryController@displaySaleOrder');
/*
Route::get('seller/einventoryproduct/{id}','EinventoryController@productdetail');
Route::get('seller/addeinventoryproductsession/{id}','EinventoryController@addinsession');
Route::get('seller/removefromsession/{id}','EinventoryController@destroyfromsession');
*/
Route::post('seller/checkouteinventory','EinventoryController@save')->name('checkouteinventory');
Route::post('seller/einventoryconfirm','EinventoryController@show');
Route::post('seller/einventorynewbuyer','EinventoryController@savebuyer');
Route::post('/einventory/salesorder','StatementController@salesorderdocument');
/*Route::get('/einventory/displaysalesorderdocument/{id}','EinventoryController@displaysalesorderdocument')->name('displaysalesorderdocument');*/
Route::get('/seller/deleteeinventorybuyer/{id}','EinventoryController@deleteeinventorybuyer');
Route::get('/inventorydetails/{id}/{user_id?}','EinventoryController@inventorydetails');
Route::get('/seller/unlinkeinventorybuyer/{id}/{user_id?}','EinventoryController@unlinkeinventorybuyer');
Route::get('/seller/saveinventorycost/{id}/{is_merchant}/{doc_no}/{doc_date}','EinventoryController@saveinventorycost');
?>