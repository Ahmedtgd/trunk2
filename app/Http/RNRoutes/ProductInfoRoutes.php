<?php

Route::post('product/info','rn\ProductController@product_info');
Route::post('product/info/bc','rn\ProductController@product_info_bc');
Route::get('products/location/{location_id}','rn\ProductController@products_location');
?>
