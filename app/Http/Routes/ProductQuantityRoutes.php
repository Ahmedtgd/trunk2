<?php
/**
 * Created by PhpStorm.
 * User:  Chris Uzor
 * Date: 11/10/2018
 * Time: 23:07
 */


Route::get('/merchant/productqty', 'ProductQuantityController@productsqty');
Route::get('merchant/productqty_since', 'ProductQuantityController@skulist_since')->name('skulist_since');
Route::post('merchant/productqty_today', 'ProductQuantityController@skulist_today');

?>
