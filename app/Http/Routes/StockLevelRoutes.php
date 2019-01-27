<?php
/**
 * Created by PhpStorm.
 * User: Chris Uzor
 * Date: 10/25/2018
 * Time: 13:49
 */


Route::get('/merchant/stocklevel', 'StockLevelController@stocklevel');
Route::get('/stocklevel_since', 'StockLevelController@stocklevel_list');
Route::post('/stocklevel_today', 'StockLevelController@stocklevel_today');

?>