<?php

Route::group(['prefix'=>'admin/logistics/'],function(){

	Route::get('company','AdminLogisticController@showLCMaster')->name('logcomp');
	Route::get('company/api','AdminLogisticController@showLCMasterAPI')->name('logcompapi');
	Route::get('commission','AdminLogisticController@showLogComm')->name('logcomm');
});
?>