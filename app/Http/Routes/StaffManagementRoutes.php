<?php
Route::group(['prefix'=>'nstaff'],function(){
    Route::get('getStaff/{userid?}','StaffManagementController@index');	
    Route::get('pah/{userid?}','StaffManagementController@pah');	
});