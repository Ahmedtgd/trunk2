<?php

Route::group(['prefix'=>'customer'],function(){
	Route::get('details/{member_id}','CustomerController@customer_details');
	Route::post('update','CustomerController@save_details');
	Route::post('ncustomer/save','CustomerController@save_ncustomer');
	Route::get('ncustomer/details/{member_id}/{user_id?}','CustomerController@ncustomer_details');
	Route::get('otherpoint/view/{member_id}','CustomerController@otherpoint');
	
});