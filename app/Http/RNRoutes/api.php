<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['namespace' => 'Products', 'prefix' => '\products'], function(){
	Route::get('/get/products', 'rn\ProductController@showProducts');
	Route::get('/get/product/{$id}', 'rn\ProductController@showProducts');
	Route::post('add/product/', 'rn\ProductController@addProduct');
	Route::post('add/product/hyper', 'rn\ProductController@addProduct_hyper');
	Route::post('add/product/tb2b', 'rn\ProductController@addProduct_tb2b');
	Route::post('add/product/ssp', 'rn\ProductController@addProduct_ssp');
	Route::post('add/product/sp', 'rn\ProductController@addProduct_sp');
	Route::post('add/product/b2b', 'rn\ProductController@addProduct_b2b');
	Route::post('add/product/retail', 'rn\ProductController@addProductRetail');
	Route::get('find/product', 'rn\ProductController@findProduct');
});
?>
