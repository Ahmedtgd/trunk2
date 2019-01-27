<?php
/**
 * Created by PhpStorm.
 * User: Chris Uzor
 * Date: 10/31/2018
 * Time: 11:47
 */
Route::get('/sales_items', 'SalesItemsController@sales_items');
Route::post('/sales_items_pdf', 'SalesItemsController@pdf');
Route::get('/sales_items_default', 'SalesItemsController@sales_items_default');
Route::post('/sales_items_today', 'SalesItemsController@sales_items_today');

Route::get('location/sales_items/{id}', 'SalesItemsController@location_sales_items');
Route::get('location/sales_items_default/{id}', 'SalesItemsController@location_sales_items_default');
Route::post('location/sales_items_today', 'SalesItemsController@location_sales_items_today');
Route::post('/sales_items_times', 'SalesItemsController@sales_items_times');
Route::get('/openDateRangeEod', 'SalesItemsController@openDateRangeEod');
