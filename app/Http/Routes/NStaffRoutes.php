<?php
Route::group(['prefix'=>'nstaff'],function(){
	Route::get('generate','NStaffController@generate');
	Route::post('save','NStaffController@save');
	Route::get('detail/{member_id}','NStaffController@details');
	Route::post('new','NStaffController@add_new_staff');
	Route::get('emailinfo/{email}','NStaffController@emailinfo');
	Route::post('validate/name','NStaffController@validate_name');
	
});

Route::get('staff/si/{location_id}/{rack_no?}','StaffSISOController@stockin');
Route::get('staff/export/{location_id}/{rack_no?}','StaffSISOController@stockinExport');

Route::get('staff/so/{location_id}/{rack_no?}','StaffSISOController@stockout');
Route::post('staff/stockreport','StaffSISOController@do_stockreport');
Route::get('staff/functions/{location_id}','StaffController@allowed_functions');
Route::get('staff/warehouse/rack/{warehouse_id}','StaffSISOController@get_warehouse_racks');