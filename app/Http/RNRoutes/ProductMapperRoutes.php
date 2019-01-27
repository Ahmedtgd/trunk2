<?php
Route::post("map/product","rn\ProductMapperController@map_product");
Route::post("unmap/product","rn\ProductMapperController@unmap_product");
Route::post("product/unmapped","rn\ProductMapperController@unmapped_product");
?>
