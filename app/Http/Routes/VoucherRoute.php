<?php
Route::get('/voucher','VoucherController@voucherList');
Route::get('/digital_voucher','VoucherController@digitalVoucher');

// Special Case of Admin being out
Route::post('/savePaperVoucher', 'VoucherController@SavePaperVoucher');
Route::post('/searchVoucher', 'VoucherController@searchVoucher');
Route::get('/searchVoucher', 'VoucherController@searchVoucher');

Route::post('/voucherRedeem', 'VoucherController@voucherRedeem');
Route::get('/voucherRedeem', 'VoucherController@voucherRedeem');


Route::post('/voucher/voucher-timeslots/{id}', array('as' => 'voucher-timeslots', 'uses' => 'VoucherController@getVoucherTimeSlots'));
Route::post('/voucher/update/{id}', array('as' => 'voucher-update', 'uses' => 'VoucherController@update'));
Route::get('/voucher/buyer_voucher', 'VoucherController@getBuyerVoucher');

Route::get('/get_voucher/{id}', 'VoucherController@get_vouchers');



Route::get('/seller/getvoucherlist/{id}','VoucherController@getvoucherlist');
Route::get('/seller/getvoucherledgerlist/{id}','VoucherController@getvoucherledgerlist');

?>