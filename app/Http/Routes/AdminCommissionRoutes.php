<?php
/* OpenSupermall Custom Routes */

/******************* Admin Commission **********/
Route::get('/admin/commission/station',array('as' =>'ComissionStation','uses'=>'StationComissionController@index' ));
Route::get('/admin/commission/station/{id}', array('as' =>'ComissionStationGet','uses'=>'StationComissionController@getStation' ));
Route::get('/admin/b2bcommission/station/{id}', array('as' =>'ComissionStationGetb2b','uses'=>'StationComissionController@getStationb2b' ));

Route::get('/admin/commission/recruiter',array('as' =>'ComissionStationRecruiter','uses'=>'StationComissionController@recruiter' ));

Route::get('/admin/commission/merchant',array('as' =>'ComissionMerchant','uses'=>'MerchantComissionController@index' ));

Route::get('/admin/logistics/logistics_commission',array('as' =>'ComissionLogistic','uses'=>'AdminCommissionController@logistic' ));
Route::get('/admin/commission/merchant/{id}', array('as' =>'ComissionMerchantGet','uses'=>'MerchantComissionController@getMerchant' ));
Route::get('/admin/b2bcommission/merchant/{id}', array('as' =>'ComissionMerchantGetb2b','uses'=>'MerchantComissionController@getMerchantb2b' ));
Route::get('/admin/commission/merchantpusher/{id}', array('as' =>'ComissionMerchantGet','uses'=>'MerchantComissionController@getMerchantpusher' ));

Route::get('/admin/commission/professional',array('as' =>'ComissionMerchantProfessional','uses'=>'MerchantComissionController@professional' ));
Route::get('/admin/commission/professional_commission/{id}',array('as' =>'MPComissionMerchantProfessional','uses'=>'MerchantComissionController@professional_commission' ));

Route::get('/admin/commission/consultant',array('as' =>'ComissionMerchantConsultant','uses'=>'MerchantComissionController@consultant' ));
Route::get('/admin/commission/user/{id}',array('as' =>'ComissionMerchantConsultantGetUser','uses'=>'MerchantComissionController@get_user' ));

Route::get('/admin/commission/pusher',array('as' =>'ComissionMerchantPusher','uses'=>'MerchantComissionController@pusher' ));
Route::get('/admin/commission/pushermerchants/{id}',array('as' =>'ComissionMerchantPusherM','uses'=>'MerchantComissionController@pushermerchants' ));

Route::get('/admin/commission/summary',array('as' =>'ComissionSummary','uses'=>'MerchantComissionController@summary' ));

Route::get('/admin/commission/smm',array('as' =>'ComissionSmm','uses'=>'MerchantComissionController@smm' ));

Route::post('admin/commission/sales_staff/{id}', 'AdminCommissionController@editSalesstaff');
Route::post('admin/commission/sales_staffmc/{id}', 'AdminCommissionController@editSalesstaffmc');
Route::post('admin/commission/sales_staffmc/targetm/{id}', 'AdminCommissionController@editSalesstaffmcm');
Route::post('admin/commission/sales_staffmc/targetr/{id}', 'AdminCommissionController@editSalesstaffmcr');
Route::post('admin/commission/logistic/{id}', 'AdminCommissionController@editLogistic');
Route::post('admin/commission/stationedit/{id}', 'AdminCommissionController@editStation');
Route::post('admin/commission/stationtype/{id}', 'AdminCommissionController@editStationtype');
Route::post('admin/b2bcommission/stationedit/{id}', 'AdminCommissionController@editStationb2b');
Route::post('admin/b2bcommission/stationtype/{id}', 'AdminCommissionController@editStationtypeb2b');
Route::post('admin/commission/merchanttype/{id}', 'AdminCommissionController@editMerchanttype');
Route::post('admin/commission/merchantedit/{id}', 'AdminCommissionController@editMerchant');
Route::post('admin/b2bcommission/merchanttype/{id}', 'AdminCommissionController@editMerchanttypeb2b');
Route::post('admin/b2bcommission/merchantedit/{id}', 'AdminCommissionController@editMerchantb2b');
Route::post('admin/commission/merchantsmm/{id}', 'AdminCommissionController@editSmm');
Route::post('admin/commission/productedit/{id}', 'AdminCommissionController@editProduct');
Route::post('admin/b2bcommission/productedit/{id}', 'AdminCommissionController@editProductb2b');
Route::post('admin/commission/productpusheredit/{id}', 'AdminCommissionController@editProductpusher');
Route::post('/admin/commission/station/fees/{id}', array('as' =>'feesStationGet','uses'=>'AdminCommissionController@station_fees' ));
Route::post('/admin/commission/merchant/fees/{id}', array('as' =>'feesMerchantGet','uses'=>'AdminCommissionController@merchant_fees' ));
Route::post('/admin/commission/merchant/order_fee/{id}', array('as' =>'ofeesMerchantGet','uses'=>'AdminCommissionController@merchant_order_fee' ));
Route::post('/admin/commission/merchant/annual_fee/{id}', array('as' =>'afeesMerchantGet','uses'=>'AdminCommissionController@merchant_annual_fee' ));
Route::post('/admin/commission/merchant/b2b_fee/{id}', array('as' =>'b2bfeesMerchantGet','uses'=>'AdminCommissionController@merchant_b2b_fee' ));
Route::post('/admin/commission/merchant/reg_fee/{id}', array('as' =>'regfeesMerchantGet','uses'=>'AdminCommissionController@merchant_reg_fee' ));

Route::post('/admin/commission/station/order_fee/{id}', array('as' =>'ofeesStationGet','uses'=>'AdminCommissionController@station_order_fee' ));
Route::post('/admin/commission/station/annual_fee/{id}', array('as' =>'afeesStationGet','uses'=>'AdminCommissionController@station_annual_fee' ));
Route::post('/admin/commission/station/b2b_fee/{id}', array('as' =>'b2bfeesStationGet','uses'=>'AdminCommissionController@station_b2b_fee' ));
Route::post('/admin/commission/station/reg_fee/{id}', array('as' =>'regfeesStationGet','uses'=>'AdminCommissionController@station_reg_fee' ));

Route::get('admin/commission/openwish', array('as' =>'ComissionOW','uses'=>'AdminCommissionController@openwishComission'));
Route::get('admin/commission/suscriptionfee', array('as' =>'ComissionFee','uses'=>'AdminCommissionController@suscriptionfeeComission'));

Route::post('admin/commission/saveopenwish', 'AdminCommissionController@saveopenwishComission');
Route::post('admin/commission/savesuscriptionfee', 'AdminCommissionController@savesuscriptionfeeComission');


?>
