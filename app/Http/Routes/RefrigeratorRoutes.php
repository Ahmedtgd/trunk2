<?php
Route::get('seller/refrigerator','RefrigeratorController@index')->name('Refrigerator');
Route::get('/production-ledger/{product_id}','RefrigeratorController@productionLedger')->name('productionLedger');
Route::get('/wastage-ledger/{product_id}','RefrigeratorController@wastageLedger')->name('wastageLedger');
Route::get("/seller/get-quantity-distribution-detail",'RefrigeratorController@getQuantityDistributionDetail')->name("distribution");
Route::get("/seller/save-fstorage-estimate",'RefrigeratorController@saveFstorateEstimate')->name("fstorageEstimate");
Route::get('/seller/get-quantity-detail','RefrigeratorController@getQuantityDetail')->name('Refrigerator');