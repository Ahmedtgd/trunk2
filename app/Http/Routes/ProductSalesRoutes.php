<?php

Route::get('/merchant/productsales', 'ProductSalesController@productsales');
Route::get('merchant/skulist_since', 'ProductSalesController@skulist_since')->name('skulist_since');
Route::post('merchant/producttoday', "ProductSalesController@skulist_today");

?>
