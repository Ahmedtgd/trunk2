<?php
/* Popups Custom Routes */
Route::get('admin/popup/user/{id?}', ['as' => 'userPopup', 'uses' => 'BuyerController@buyerInformation']);
Route::get('admin/popup/station/{id}', ['as' => 'stationPopup', 'uses' => 'UserController@getEditStation']);
Route::get('admin/popup/infostation/{id}', ['as' => 'stationPopup', 'uses' => 'UserController@getInfoStation']);
Route::get('admin/popup/merchant/{id}', ['as' => 'merchantPopup', 'uses' => 'UserController@getEditMerchant']);
Route::get('admin/popup/order', ['as' => 'orderPopup', 'uses' => 'PopupController@usorderer']);
Route::get('admin/popup/user/{recruiter_id}', ['as' => 'recruiterPopup', 'uses' => 'UserController@getEditMerchant']);
/*This is an ajax route for Station check if record present present for a station id*/
Route::get('admin/popup/lx/check/station/{station_id}','UserController@check_for_station');
Route::get('admin/popup/lx/check/stationu/{station_id}','UserController@check_for_stationu');
Route::get('admin/popup/check/user/{user_id}','UserController@check_for_user');
Route::get('admin/popup/lx/check/user/{recruiter_id}','UserController@check_for_user');
Route::get('admin/popup/lx/check/user/{user_id}','UserController@check_for_user');
Route::get('admin/popup/lx/check/user/{employee_id}','UserController@check_for_user');
Route::get('admin/popup/lx/check/user/{id}','UserController@check_for_merchantid');
Route::get('admin/popup/lx/check/order/{id}','UserController@check_for_orderid');
//Route::get('admin/popup/lx/check/user/{id}','UserController@check_for_merchantid');
Route::get('admin/popup/lx/check/merchant/{id}','UserController@check_for_merchant');
Route::get('admin/popup/lx/check/merchantu/{id}','UserController@check_for_merchantu');
Route::get('admin/popup/lx/check/product/{id}','UserController@check_for_product');
Route::post('/sendmail', 'PopupController@sendmail');
/*End Route for Popups */
?>
