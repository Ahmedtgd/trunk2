<?php
Route::get('/merchant/stockout', 'StockOutController@stockout_default');
Route::post('/merchant/stockouttoday', 'StockOutController@stockout_today');
Route::get('/merchant/stockoutdetails', 'StockOutController@stockout_details');
Route::get('/merchant/stockoutsince', 'StockOutController@stockout_since');
Route::post('/merchant/stockout_range', 'StockOutController@stockout_range');
