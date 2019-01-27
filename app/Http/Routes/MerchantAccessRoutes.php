<?php
Route::group(['prefix'=>'admin/merchant/module'],function(){
	Route::get('access/{merchant_id}','MerchantModuleAccessController@access');
	Route::post('access/update','MerchantModuleAccessController@update_access');
});